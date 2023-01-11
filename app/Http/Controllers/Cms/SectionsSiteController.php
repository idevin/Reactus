<?php

namespace App\Http\Controllers\Cms;

use App\Models\Announcement;
use App\Models\Section;
use App\Models\SectionSite;
use App\Models\Template;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Validator;

class SectionsSiteController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Перенос раздела на сайт', 'sections_site.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $title = 'Перенос раздела на сайт';

        $breadcrumbs = $this->breadcrumbs;

        $siteSections = SectionSite::query()->with(['site', 'section', 'template']);

        $fields = $this->setFields($siteSections);

        $filter = new CmsFilter(SectionSite::class, 'sections_site.index');

        $filter->addField('section::title', 'Название раздела')
            ->addField('site::domain', 'Домен')
            ->addButton('Создать', 'sections_site.create');

        $filter = $filter->render();

        return view('cms.sections_site.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|\Illuminate\Contracts\View\View|Application
    {
        $title = 'Новый перенос раздела в сайт';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;

        $form = new SectionSite();
        $action = 'sections_site.store';

        $sites = \App\Models\Site::selectOptions();
        $sections = Section::selectOptions(null, true);
        $templates = Template::selectOptions();

        return view('cms.sections_site.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'sites', 'sections', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        $announce = isset($inputData['announce']) ? 1 : 0;
        $moderated = isset($inputData['moderated']) ? 1 : 0;

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $section = Section::find($inputData['section_id']);

            if (empty($section->parent_id)) {
                return redirect()->back()->withInput($inputData)->withErrors('Нельзя переносить корневой раздел');
            }

            $newSectionRoot = Section::roots()->bySite($inputData['site_id'])->first();
            $sections = $section->getDescendantsAndSelf()->toHierarchy();

            if ($announce == 1) {

                Announcement::query()->firstOrCreate([
                    'title' => $section->title,
                    'description' => $section->content_short,
                    'object_type' => Section::class,
                    'object_id' => $newSectionRoot->id,
                    'site_id' => $newSectionRoot->site_id,
                    'announce_type' => Section::class,
                    'announce_id' => $section->id
                ]);

                SectionSite::query()->create([
                    'site_id' => $inputData['site_id'],
                    'from_site_id' => $section->site_id,
                    'section_id' => $inputData['section_id'],
                    'to_section_id' => $newSectionRoot->id,
                    'announce' => $announce,
                    'moderated' => $moderated
                ]);

            } else {
                $newSectionRootParent = self::copySections($sections, null, $newSectionRoot);

                $data = [
                    'site_id' => $inputData['site_id'],
                    'from_site_id' => $section->site_id,
                    'to_section_id' => $newSectionRootParent->id,
                    'announce' => $announce,
                    'moderated' => $moderated
                ];

                SectionSite::query()->create($data);
            }

            session()->flash('msg.success', 'Запись сохранена');

            return redirect()->route('sections_site.index');
        }
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'section_id' => 'required',
            'site_id' => 'required',
        ], [
            'section_id.required' => 'Поле раздел обязательно для заполнения',
            'site_id.required' => 'Поле домен обязательно для заполнения'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $sectionSite = SectionSite::query()->find($id);

        if (!$sectionSite) {
            session()->flash('error', 'Раздел не перенесен или не найден');
            return redirect()->route('sections_site.index');
        }

        $newSectionRoot = Section::roots()->bySite($sectionSite->from_site_id)->first();
        $sections = $sectionSite->toSection->getDescendantsAndSelf()->toHierarchy();

        if ($sectionSite->announce == 1) {

            Announcement::query()->whereSiteId($sectionSite->site_id)
                ->whereObjectType(Section::class)->whereAnnounceId($sectionSite->section_id)
                ->whereObjectId($sectionSite->to_section_id)->delete();

        } else {
            self::copySections($sections, $sectionSite, $newSectionRoot);
        }

        $sectionSite->delete();

        session()->flash('success', 'Данные удалены');

        return redirect()->route('sections_site.index');
    }

    public static function copySections($sections, $sectionSite, $newSectionRoot)
    {
        $newSectionRootParent = null;

        if (count($sections) > 0) {
            if ($sectionSite) {
                $inputData['site_id'] = $sectionSite->from_site_id;
            }

            foreach ($sections as $sectionItem) {
                $newSectionRootParent = self::createSectionCopy($newSectionRoot, $sectionItem, $inputData);

                if (count($sectionItem->children) > 0) {
                    foreach ($sectionItem->children as $child) {
                        $newSection = self::createSectionCopy($newSectionRootParent, $child, $inputData);
                        self::setChildren($newSection, $child, $inputData);
                    }
                }
                $sectionItem->forceDelete();
            }
        }

        return $newSectionRootParent;
    }

}
