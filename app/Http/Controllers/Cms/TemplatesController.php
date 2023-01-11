<?php

namespace App\Http\Controllers\Cms;

use App\Models\Template;
use App\Models\TemplateScheme;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Exception;
use File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Session;
use Validator;

class TemplatesController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Шаблоны', 'templates.index'];

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(): Factory|\Illuminate\Contracts\View\View|Application
    {
        $title = 'Шаблоны';

        $breadcrumbs = $this->breadcrumbs;

        $templates = Template::query();

        $fields = $this->setFields($templates);

        $filter = new CmsFilter(Template::class, 'templates.index');

        $filter->addField('name', 'Название')
            ->addField('alias', 'Alias')
            ->addButton('Создать', 'templates.create');

        $filter = $filter->render();

        return view('cms.templates.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $title = 'Новый шаблон';

        $this->breadcrumbs[] = ['Создание шаблона'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Template();
        $action = 'templates.store';
        $create = true;
        $template = $form;

        list($templateSchemes, $templateSchemeArray) = $this->getTemplateSchemes($form);

        return view('cms.templates.new_form', compact('templateSchemeArray', 'templateSchemes', 'form', 'title',
            'breadcrumbs', 'action', 'template', 'create'));
    }

    public function getTemplateSchemes($form): array
    {
        $templateSchemes = TemplateScheme::orderBy('name')->get();

        $templateSchemeArray = $form->templateSchemes->pluck('id');

        if (count($templateSchemeArray) > 0) {
            $templateSchemeArray = $templateSchemeArray->toArray();
        } else {
            $templateSchemeArray = [];
        }
        return [$templateSchemes, $templateSchemeArray];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $data = [
                'name' => $inputData['name'],
                'default' => isset($inputData['default']) ? 1 : 0,
                'alias' => $inputData['alias'],
                'hidden' => isset($inputData['hidden']) ? 1 : 0,
                'template_type' => isset($inputData['template_type']) ?? Template::TYPE_FREE
            ];

            if (isset($inputData['default'])) {
                Template::where('default', 1)->update(['default' => 0]);
                session(['theme' => $inputData['alias']]);
            }

            $template = Template::create($data);

            return self::syncTemplatesWithRedirect($inputData, $template);
        }
    }

    public static function getValidator($data, $exceptFields = [])
    {
        $rules = [
            'name' => 'required',
            'alias' => 'required|alpha_dash|unique:mysql.template,alias'
        ];
        $messages = [
            'name.required' => 'Поле имя обязательно для заполнения',
            'alias.required' => 'Поле alias обязательно для заполнения'
        ];

        if (!empty($exceptFields)) {
            foreach ($exceptFields as $field) {
                unset($rules[$field]);
            }
        }

        return Validator::make($data, $rules, $messages);
    }

    public static function syncTemplatesWithRedirect($inputData, $template): RedirectResponse
    {
        if (isset($inputData['template_scheme_id'])) {
            $template->templateSchemes()->sync($inputData['template_scheme_id']);
        } else {
            $template->templateSchemes()->sync([]);
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('templates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function edit(int $id)
    {
        $title = 'Шаблоны';

        $form = Template::findOrFail($id);
        $template = $form;

        $this->breadcrumbs[] = ['Редактирование шаблона'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'templates.update';

        list($templateSchemes, $templateSchemeArray) = $this->getTemplateSchemes($form);

        return view('cms.templates.edit', compact('templateSchemeArray', 'form', 'title', 'breadcrumbs', 'action',
            'template', 'templateSchemes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $template = Template::findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData, ['alias']);

        $rules = $validator->getRules();

        $validator->setRules($rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            if (isset($inputData['default'])) {
                Template::where(['default' => 1])->update(['default' => 0]);
                if (isset($inputData['alias'])) {
                    session(['theme' => $inputData['alias']]);
                }
            }

            $data = [
                'name' => $inputData['name'],
                'default' => isset($inputData['default']) ? 1 : 0,
                'hidden' => isset($inputData['hidden']) ? 1 : 0,
                'template_type' => isset($inputData['template_type']) ?? Template::TYPE_FREE
            ];

            $this->updateFiles($template, $data);

            Template::query()->findOrFail($id)->update($data);

            return self::syncTemplatesWithRedirect($inputData, $template->refresh());
        }
    }

    private function updateFiles($template, $data)
    {
        if (isset($data['alias'])) {
            self::moveTemplate($template, $data);
        }
    }

    public static function moveTemplate($template, $data)
    {
        $appPath = getenv('DOCUMENT_ROOT') . '/../../app-netgamer/';
        $enginePath = $appPath . 'resources/stub-public/theme/';

        $oldEnginePath = $enginePath . $template->alias;
        $newEnginePath = $enginePath . $data['alias'];

        if (file_exists($oldEnginePath)) {
            File::move($oldEnginePath, $newEnginePath);
        }

        $oldTemplatePath = $appPath . 'resources/views/' . $template->alias . '.blade.php';
        $newTemplatePath = $appPath . 'resources/views/' . $data['alias'] . '.blade.php';

        if (file_exists($oldTemplatePath)) {
            File::move($oldTemplatePath, $newTemplatePath);
        }

        $oldThemePath = $appPath . 'resources/views/theme/' . $template->alias;
        $newThemePath = $appPath . 'resources/views/theme/' . $data['alias'];

        if (file_exists($oldThemePath)) {
            File::move($oldThemePath, $newThemePath);
        }

        Session::forget('theme');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        Template::findOrFail($id)->delete();

        session()->flash('success', 'Шаблон удален!');

        return redirect()->route('templates.index');
    }
}
