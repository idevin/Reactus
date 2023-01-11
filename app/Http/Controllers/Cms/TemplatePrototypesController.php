<?php

namespace App\Http\Controllers\Cms;

use App\Models\Comment;
use App\Models\Modules\Module;
use App\Models\Modules\ModuleSettings;
use App\Models\Template;
use App\Models\TemplatePrototype;
use App\Models\TemplatePrototypeStroke;
use App\Models\TemplatePrototypeStrokeModule;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class TemplatePrototypesController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Прототипы Шаблонов', 'template_prototypes.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $title = 'Прототипы Шаблонов';

        $breadcrumbs = $this->breadcrumbs;

        $templatePrototypes = TemplatePrototype::query()->with(['strokes' => function ($query) {
            $query->with(['modules'])->orderBy('position')->orderBy('sort_order');
        }]);

        $fields = $this->setFields($templatePrototypes);

        $filter = new CmsFilter(Comment::class, 'template_prototypes.index');

        $positions = ModuleSettings::$positionOptions;

        $filter->addField('template_prototype::template', 'Шаблон')
            ->addButton('Создать', 'template_prototypes.create');

        $filter = $filter->render();

        self::clearPrototypes(array_flip($positions), 0);

        return view('cms.template_prototypes.index',
            compact('fields', 'title', 'filter', 'breadcrumbs', 'positions'));
    }

    private static function clearPrototypes($positionOptions, $cleared = 1)
    {
        if (session('cleared') == 0) {
            $empty = [];

            $clearedSession = array_map(function () {
                return [];
            }, $positionOptions, ...$empty);

            session($clearedSession);

            session(['cleared' => $cleared]);
        }
    }

    public function create(Request $request): View|Factory|RedirectResponse|Application
    {
        $title = 'Новый прототип';

        $this->breadcrumbs[] = ['Создание прототипа'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new TemplatePrototype();
        $action = 'template_prototypes.store';

        $templates = Template::getSelect();

        $modules = Module::getSelect();

        $stroke = $request->get('add_stroke');
        $addModule = $request->get('add_module');
        $deleteModule = $request->get('delete_module');
        $deleteStroke = $request->get('delete_stroke');

        $positionOptions = array_flip(ModuleSettings::$positionOptions);

        self::clearPrototypes($positionOptions);

        if ($stroke) {
            $session = session()->all();
            $strokeSortOrder = $request->get('sort_order', 1);
            $position = ModuleSettings::$positionOptions[$stroke];

            if (empty($strokeSortOrder)) {
                $strokeSortOrder = 1;
            }

            if (!isset($session[$position])) {
                $session[$position] = [];
            }

            $session[$position][$strokeSortOrder] = [];

            ksort($session[$position]);

            session([$position => $session[$position]]);

            return redirect(route('template_prototypes.create'));
        }

        if ($addModule) {
            $strokeNumber = $request->get('stroke');
            $moduleId = $request->get('module_id');
            $sortOrder = $request->get('sort_order', 1);
            $position = ModuleSettings::$positionOptions[$addModule];
            $module = Module::query()->find($moduleId);

            $session = session()->all();

            if (empty($sortOrder)) {
                $sortOrder = 1;
            }

            if (!$module) {
                return redirect()->back()->withInput($request->all())->withErrors('Модуль не найден');
            }

            $session[$position][$strokeNumber][$sortOrder] = $module;

            ksort($session[$position][$strokeNumber]);

            session([$position => $session[$position]]);

            return redirect(route('template_prototypes.create'));
        }

        if ($deleteModule) {
            $position = ModuleSettings::$positionOptions[$deleteModule];
            $strokeNumber = $request->get('stroke');
            $moduleNumber = $request->get('module');
            $session = session()->all();

            if (isset($session[$position]) && isset($session[$position][$strokeNumber])
                && isset($session[$position][$strokeNumber][$moduleNumber])) {

                unset($session[$position][$strokeNumber][$moduleNumber]);

                $newSession = [
                    $position => $session[$position]
                ];

                session($newSession);

                return redirect(route('template_prototypes.create'));
            } else {
                return redirect()->back()->withInput($request->all())->withErrors('Модуль не найден');
            }
        }

        if ($deleteStroke) {
            $position = ModuleSettings::$positionOptions[$deleteStroke];
            $session = session()->all();

            $strokeNumber = $request->get('stroke');

            if (isset($session[$position]) && isset($session[$position][$strokeNumber])) {
                unset($session[$position][$strokeNumber]);

                $newSession = [$position => $session[$position]];

                session($newSession);

                return redirect(route('template_prototypes.create'));

            } else {
                return redirect()->back()->withInput($request->all())->withErrors('Строка не найдена');
            }
        }

        $session = session()->all();

        $route = 'template_prototypes.create';

        return view('cms.template_prototypes.new_form',
            compact('form', 'action', 'breadcrumbs', 'title',
                'templates', 'positionOptions', 'session', 'modules', 'route'));
    }

    public function store(Request $request): RedirectResponse
    {
        $inputData = $request->all();

        $session = session()->all();

        $validator = static::getValidator($inputData, $session);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $templatePrototype = TemplatePrototype::query()->create(self::getData($inputData));

            foreach (ModuleSettings::$positionOptions as $position => $positionOption) {
                foreach ($session[$positionOption] as $sortOrder => $stroke) {

                    $templatePrototypeStroke = TemplatePrototypeStroke::query()->create(
                        [
                            'template_prototype_id' => $templatePrototype->id,
                            'sort_order' => $sortOrder,
                            'position' => $position
                        ]
                    );

                    foreach ($stroke as $moduleSortOrder => $module) {

                        TemplatePrototypeStrokeModule::query()->create([
                            'template_prototype_stroke_id' => $templatePrototypeStroke->id,
                            'sort_order' => $moduleSortOrder,
                            'module_id' => $module->id
                        ]);
                    }
                }
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('template_prototypes.index');
        }
    }

    public static function getValidator($data, $session)
    {
        $rules = [
            'template_id' => 'required'
        ];

        $messages = [
            'template_id.required' => 'Выберите шаблон'
        ];

        foreach (ModuleSettings::$positionOptions as $positionOption) {
            if (isset($session[$positionOption]) && !empty($session[$positionOption])) {
                foreach ($session[$positionOption] as $stroke) {
                    if (empty($stroke)) {
                        $rules += [
                            'strokes' => 'required'
                        ];

                        $messages += [
                            'strokes.required' => 'Некоторые строки не имеют модулей'
                        ];

                        break 2;
                    }
                }
            } else {
                $rules += [
                    'blocks' => 'required',
                    'name' => 'required'
                ];

                $messages += [
                    'blocks.required' => 'Данные блоков не заполнены',
                    'name.required' => 'Назовите шаблон'
                ];

                break;
            }
        }


        return Validator::make($data, $rules, $messages);
    }

    public static function getData(array $inputData): array
    {
        return [
            'template_id' => $inputData['template_id'],
            'name' => $inputData['name'],
            'description' => $inputData['description'] ?? null
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function edit(int $id, Request $request): RedirectResponse|View
    {
        $title = 'Редактирование';

        $form = TemplatePrototype::query()->with(['strokes' => function ($query) {
            $query->with(['modules'])->orderBy('position')->orderBy('sort_order');
        }])->find($id);

        $templates = Template::getSelect();
        $modules = Module::getSelect();
        $route = 'template_prototypes.edit';
        $stroke = $request->get('add_stroke');
        $addModule = $request->get('add_module');
        $deleteModule = $request->get('delete_module');
        $deleteStroke = $request->get('delete_stroke');
        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'template_prototypes.update';
        $positionOptions = array_flip(ModuleSettings::$positionOptions);

        if ($stroke) {

            $strokeSortOrder = $request->get('sort_order', 1);

            if (empty($strokeSortOrder)) {
                $strokeSortOrder = 1;
            }

            TemplatePrototypeStroke::query()->firstOrCreate([
                'template_prototype_id' => $form->id,
                'position' => (int)$stroke,
                'sort_order' => (int)$strokeSortOrder
            ]);

            return redirect(route($route, ['template_prototype' => $id]));
        }

        if ($deleteStroke) {

            $strokeNumber = $request->get('stroke');

            $stroke = TemplatePrototypeStroke::query()->where([
                'template_prototype_id' => $form->id,
                'position' => $deleteStroke,
                'sort_order' => $strokeNumber
            ])->first();

            if ($stroke) {
                $stroke->delete();
                session()->flash('success', 'Строка добавлена!');
                return redirect(route($route, ['template_prototype' => $id]));

            } else {
                return redirect()->back()->withInput($request->all())->withErrors('Строка не найдена');
            }
        }

        if ($addModule) {
            $strokeNumber = $request->get('stroke');
            $moduleId = $request->get('module_id');
            $sortOrder = $request->get('sort_order', 1);
            $module = Module::query()->find((int)$moduleId);

            if (empty($sortOrder)) {
                $sortOrder = 1;
            }

            if (!$module) {
                return redirect()->back()->withInput($request->all())->withErrors('Модуль не найден');
            }

            $stroke = TemplatePrototypeStroke::query()->where([
                'position' => $addModule,
                'sort_order' => $strokeNumber
            ])->first();

            if (!$stroke) {
                return redirect()->back()->withInput($request->all())->withErrors('Строка не найдена');
            }

            TemplatePrototypeStrokeModule::query()->firstOrCreate([
                'template_prototype_stroke_id' => $stroke->id,
                'module_id' => $module->id,
                'sort_order' => (int)$sortOrder
            ]);

            session()->flash('success', 'Модуль добавлен!');

            return redirect(route($route, ['template_prototype' => $id]));
        }

        if ($deleteModule) {
            $strokeNumber = $request->get('stroke');
            $moduleNumber = $request->get('module');

            $stroke = TemplatePrototypeStroke::query()->where([
                'position' => $deleteModule,
                'sort_order' => $strokeNumber
            ])->first();

            if (!$stroke) {
                return redirect()->back()->withInput($request->all())->withErrors('Строка не найдена');
            }

            $module = TemplatePrototypeStrokeModule::query()->where([
                'template_prototype_stroke_id' => $stroke->id,
                'sort_order' => $moduleNumber
            ])->first();

            if (!$module) {
                return redirect()->back()->withInput($request->all())->withErrors('Модуль не найден');
            } else {
                $module->delete();
            }
            session()->flash('success', 'Модуль удален!');
            return redirect(route($route, ['template_prototype' => $id]));

        }

        $sessionArray = [];

        foreach ($positionOptions as $name => $index) {
            foreach ($form->strokes as $strokeObject) {
                if ($strokeObject->position == $index) {
                    $sessionArray[$name][$strokeObject->sort_order] = [];
                    foreach ($strokeObject->modules as $module) {
                        $sessionArray[$name][$strokeObject->sort_order][$module->sort_order] = $module->module;
                    }
                    ksort($sessionArray[$name][$strokeObject->sort_order]);
                }
            }
        }

        session($sessionArray);

        $session = session()->all();

        return view('cms.template_prototypes.edit', compact('form', 'title', 'breadcrumbs', 'action',
            'templates', 'positionOptions', 'session', 'modules', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $inputData = $request->all();
        $session = session()->all();
        $validator = static::getValidator($inputData, $session);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $templatePrototype = TemplatePrototype::query()->find($id);

            if (!$templatePrototype) {
                return redirect()->back()->withInput($inputData)->withErrors('Прототип шаблона не найден');
            }

            $templatePrototype->delete();

            \DB::statement("ALTER TABLE `{$templatePrototype->getTable()}` AUTO_INCREMENT=1");

            $templatePrototype = TemplatePrototype::query()->create(self::getData($inputData));

            foreach (ModuleSettings::$positionOptions as $position => $positionOption) {
                foreach ($session[$positionOption] as $sortOrder => $stroke) {

                    $templatePrototypeStroke = TemplatePrototypeStroke::query()->create(
                        [
                            'template_prototype_id' => $templatePrototype->id,
                            'sort_order' => $sortOrder,
                            'position' => $position
                        ]
                    );

                    foreach ($stroke as $moduleSortOrder => $module) {

                        TemplatePrototypeStrokeModule::query()->create([
                            'template_prototype_stroke_id' => $templatePrototypeStroke->id,
                            'sort_order' => $moduleSortOrder,
                            'module_id' => $module->id
                        ]);
                    }
                }
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('template_prototypes.index');
        }
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
        $comment = TemplatePrototype::query()->find($id);
        $comment?->delete();
        session()->flash('success', 'Удалено!');

        return redirect()->route('template_prototypes.index');
    }
}
