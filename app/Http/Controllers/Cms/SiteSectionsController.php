<?php

namespace App\Http\Controllers\Cms;

use App\Models\Permission;
use App\Models\Section;
use App\Models\Site as SiteModel;
use App\Models\SiteSection;
use App\Models\Template;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Section as SectionTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

class SiteSectionsController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;
    use SectionTrait;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Перенос сайта в раздел', 'site_sections.index'];

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
        $title = 'Перенос сайта в раздел';

        $breadcrumbs = $this->breadcrumbs;

        $siteSections = SiteSection::query()->with(['site', 'section', 'template']);

        $fields = $this->setFields($siteSections);

        $filter = new CmsFilter(Permission::class, 'site_sections.index');

        $filter->addButton('Создать', 'site_sections.create');

        $filter = $filter->render();

        return view('cms.site_sections.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Application|Factory|Response|View
     * @internal param Request $request
     */
    public function create()
    {
        $title = 'Создать';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new SiteSection();
        $action = 'site_sections.store';

        $sites = SiteModel::getTreeOptions(null, true, false);
        $sections = Section::selectOptions();
        $templates = Template::selectOptions();

        return view('cms.site_sections.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'sites', 'sections', 'templates'));
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

            SiteSection::query()->firstOrCreate(self::getData($inputData));

            $site = SiteModel::query()->find($inputData['site_id']);
            $transferToSection = Section::find($inputData['section_id']);

            if (!empty($site->sections)) {

                foreach ($site->sections as $section) {
                    if ($section->parent_id == null) {
                        $section->title = idnToAscii($site->domain);
                        $section->slug = slugify(idnToAscii($site->domain));
                        $section->site_id = $transferToSection->site_id;
                    }
                }
            }

            return redirect()->route('site_sections.index');
        }
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'section_id' => 'required',
            'site_id' => 'required',
            'template_id' => 'required'
        ], [
            'section_id.required' => 'Поле раздел обязательно для заполнения',
            'site_id.required' => 'Поле домен обязательно для заполнения',
            'template_id.required' => 'Поле шаблон обязательно для заполнения'
        ]);
    }

    #[ArrayShape(['site_id' => "mixed", 'section_id' => "mixed", 'template_id' => "mixed",
        'active' => "int"])]
    public static function getData($inputData): array
    {
        return [
            'site_id' => $inputData['site_id'],
            'section_id' => $inputData['section_id'],
            'template_id' => $inputData['template_id'],
            'active' => isset($inputData['active']) ? 1 : 0
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $title = 'Редактирование';

        $form = SiteSection::findOrFail($id);

        $this->breadcrumbs[] = ['Редактирование переноса'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'site_sections.update';

        $sites = SiteModel::selectOptions();
        $sections = Section::selectOptions(null, false, $form->site_id);
        $templates = Template::selectOptions();

        return view('cms.site_sections.edit', compact('form', 'title', 'breadcrumbs', 'action', 'sites', 'sections', 'templates'));
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
        $field = SiteSection::query()->findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $field->update(self::getData($inputData));

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('site_sections.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Redirector|Application|RedirectResponse
     */
    public function destroy(int $id): Application|RedirectResponse|Redirector
    {
        $siteSection = SiteSection::query()->find($id);

        $siteSection?->delete();

        session()->flash('success', 'Данные удалены');
        return redirect(route('site_sections.index'));
    }
}
