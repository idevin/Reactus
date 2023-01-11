<?php

namespace App\Http\Controllers\Cms;

use App\Models\Section;
use App\Models\SectionSetting;
use App\Models\SectionUser;
use App\Models\Site;
use App\Models\Site as SiteModel;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Intervention\Image\Image;
use Session;
use Validator;

class SectionsController extends CmsController
{
    use DomainTrait;
    use CustomValidators;
    use Media;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Разделы', 'sections.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $title = 'Разделы';
        $breadcrumbs = $this->breadcrumbs;

        $siteId = request()->get('site_id', $this->getSite(env('DOMAIN'))->site_id);

        if ($siteId) {
            $site = SiteModel::find($siteId);
        } else {
            $site = SiteModel::roots()->first();
        }

        $roots = Section::roots();

        $root = $roots->bySite($site->id)->get()->first();

        if (!$root) {
            $root = Section::create([
                'title' => 'Разделы',
                'slug' => slugify('Разделы'),
                'parent_id' => null,
                'site_id' => $site->id
            ]);

        }
        Section::rebuild(true);

        $treeData = Section::withTrashed()->bySite($siteId)->whereNotNull('parent_id')
            ->get()->toHierarchy();

        return view('cms.sections.index', compact('title', 'site', 'breadcrumbs', 'treeData'));
    }

    public function undelete($id)
    {
        $section = Section::withTrashed()->find($id);
        if ($section) {
            $section->restore();
        }

        return redirect()
            ->route('sections.index', ['site_id' => \request('site_id')])
            ->with('success', 'Раздел полностью восстановлен!');
    }

    public function updateTree(Request $request)
    {
        parent::saveTree($request, Section::class);
        session()->flash('success', 'Запись сохранена');
        return redirect()->route('sections.index', ['site_id' => \request('site_id')]);
    }

    public function redirectToSites($text = null)
    {
        if ($text == null) {
            $text = 'Сначала добавьте сайт';
        }

        Session::flash('error', $text);
        return redirect(route('sites.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $title = 'Создать';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Section();
        $action = 'sections.store';
        $settings = new SectionSetting();
        $siteId = $request->get('site_id');
        $site = \App\Models\Site::find($siteId);
        $sections = Section::getOptionValues($site, true, [$form->id]);

        $tags = null;

        return view('cms.sections.new_form', compact('form', 'title', 'breadcrumbs', 'action', 'settings', 'site', 'sections', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return false|Application|JsonResponse|RedirectResponse|Redirector|string
     */
    public function store(Request $request): bool|JsonResponse|string|Redirector|RedirectResponse|Application
    {
        $requestData = $request->all();
        $site = Site::find($requestData['site_id']);
        $sectionRoot = Section::roots()->bySite($site->id)->get()->first();
        $validator = self::getValidator($requestData);


        if (!$validator->fails()) {

            if (!$site) {
                return $this->error('Домен не найден...');
            } else {

                if (!empty($requestData['parent_id'])) {
                    $parent = Section::query()->find($requestData['parent_id']);
                    $parentId = $parent?->id;
                } else {
                    $parentId = $sectionRoot->id;
                }

                $contentShort = isset($requestData['content_short']) ?
                    truncate_content($requestData['content_short'], 160, true, true) : null;

                $section = Section::query()->create([
                    'title' => $requestData['title'],
                    'content' => !empty($requestData['content']) ? $requestData['content'] : null,
                    'content_short' => $contentShort,
                    'image' => null,
                    'site_id' => $site->id,
                    'parent_id' => $parentId,
                    'is_secret' => 0,
                    'user_id' => Auth::user()->id
                ]);

                if (!empty($requestData['image'])) {
                    $this->processImages($requestData, $section);
                }

                $section->update([
                    'image' => $requestData['image'] ?? $section->image
                ]);

                if (!empty($requestData['tags'])) {
                    $section->tag(explode(',', $requestData['tags']));
                }

                SectionSetting::saveFromRequest($requestData, $section);

                return redirect(route('sections.index', ['site_id' => $site->id]));
            }
        } else {
            return redirect()->back()->withErrors($validator->errors());
        }
    }

    public static function getValidator($data, $except = [], $customErrors = [])
    {
        $default = [
            'title' => 'required|max:70|min:1',
            'parent_id' => 'required',
            'short_content' => 'max:160'
        ];

        $messages = [
            'parent_id.required' => 'Выберите раздел',
            'title.required' => 'Напишите название',
            'title.unique' => 'Такое название раздела уже есть...',
            'title.max' => 'Название раздела не должно быть больше 200 символов',
            'title.min' => 'Название раздела должно быть не меньше 10 символов',
            'other_section_id.required' => 'Если хотите перенести раздел на другой ресурс, выберите раздел у ресурса',
            'short_content.max' => 'Краткое описание раздела должно быть не больше 160 символов'
        ];

        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->except($except)->toArray();

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $title = 'Разделы';
        $siteId = $request->get('site_id');
        $form = Section::findOrFail($id);
        $site = SiteModel::findOrFail($siteId);
        $sections = Section::getOptionValues($site, true, [$form->id]);

        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'sections.update';
        $tags = $this->getTags($form->tags);

        $settings = SectionSetting::where('section_id', $form->id)->first();
        if (!$settings) {
            $settings = new SectionSetting();
        }

        return view('cms.sections.edit', compact('form', 'title', 'breadcrumbs', 'action', 'sections', 'tags', 'site', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $site = Site::find($requestData['site_id']);

        $section = Section::find($id);

        if (!$section) {
            return error404('Раздел не найден...');
        }

        $customErrors = [];
        $excludedErrors = [];

        if ($section->parent_id == null) {
            $excludedErrors[] = 'parent_id';
        }

        $validator = self::getValidator($requestData, $excludedErrors, $customErrors);

        if (!$validator->fails()) {

            if (!$site) {
                return $this->error('Домен не найден...');
            } else {

                $parentId = null;
                $parent = null;
                if (!empty($requestData['parent_id'])) {
                    $parent = Section::find($requestData['parent_id']);
                    if ($parent) {
                        $parentId = $parent->id;
                    }
                } else {
                    $parentId = $section->parent_id;
                }

                $contentShort = isset($requestData['content_short']) ?
                    truncate_content($requestData['content_short'], 160, true, true) : null;

                if (!empty($requestData['image'])) {
                    $this->processImages($requestData, $section);
                }

                if ($parent && $section->id != $parent->id) {
                    $section->makeChildOf($parent);
                }

                $section->update([
                    'title' => $requestData['title'],
                    'content' => $requestData['content'],
                    'content_short' => $contentShort,
                    'site_id' => $site->id,
                    'parent_id' => $parentId,
                    'image' => !empty($requestData['image']) ? $requestData['image'] : $section->image
                ]);


                if (!empty($requestData['tags'])) {
                    $requestTags = explode(',', $requestData['tags']);
                    unset($requestTags['[]']);

                    $section->retag($requestTags);
                } else {
                    $section->untag();
                }

                SectionSetting::saveFromRequest($requestData, $section);

                return redirect(route('sections.index', ['site_id' => $site->id]));
            }
        } else {
            return redirect()->back()->withErrors($validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $siteId = request()->get('site_id');

        $site = SiteModel::find($siteId);

        $section = Section::bySite($site->id)->find($id);

        if (!$section) {
            session()->flash('error', 'Раздел не найден');
            return redirect()->route('sections.index', ['site_id' => $siteId]);
        }

        if (count($section->articles) > 0) {
            session()->flash('error', 'Нельзя удалить раздел, так как у него есть статьи');
            return redirect()->route('sections.index', ['site_id' => \request('site_id')]);
        }

        $section->delete();

        session()->flash('success', 'Готово!');
        return redirect()->route('sections.index', ['site_id' => \request('site_id')]);
    }

    public function massDelete(Request $request)
    {
        $objects = $request->get('o');

        if (!empty($objects)) {
            $objects = explode(',', $objects);
            if (!empty($objects)) {
                $ids = [];

                function noDelete($chidren)
                {
                    foreach ($chidren as $child) {
                        if (count($child->articles) > 0) {
                            $ids[] = $child->id;
                        }
                        if (count($child->children) > 0) {
                            noDelete($child->children);
                        }
                    }
                }

                collect($objects)->map(function ($id) use (&$ids) {
                    $section = Section::find($id);
                    if ($section) {
                        if (count($section->children) > 0) {
                            foreach ($section->children as $child) {
                                if (count($child->articles) > 0) {
                                    $ids[] = $section->id;
                                    $ids[] = $child->id;
                                }
                                if (count($child->children) > 0) {
                                    noDelete($child->children);
                                }
                            }
                        }
                    }
                });
            }
        }
        $notice = 'Готово!';

        if (!empty($ids)) {
            foreach ($ids as $id) {
                foreach ($objects as $index => $object) {
                    if ($object == $id) {
                        unset($objects[$index]);
                    }
                }
            }

            $notice = 'Некоторые разделы не были удалены так как в них есть статьи';
        }

        collect($objects)->map(function ($object) {
            $section = Section::withTrashed()->find($object);
            if ($section) {
                if ($section->trashed()) {
                    $section->forceDelete();
                } else {
                    $section->delete();
                }
            }
        });

        session()->flash('success', $notice);
    }

    public function destroyForever($id)
    {
        $section = Section::withTrashed()->find($id);
        if ($section) {
            $section->forceDelete();
        }

        return redirect()
            ->route('sections.index', ['site_id' => \request('site_id')])
            ->with('success', 'раздел полностью удален!');
    }

    public function processImages(&$inputData, $section)
    {
        $domain = $section->depth > 1 ? $section->getMainDomain() : $section->domain;

        $saveImages = function (&$inputData, $image, $section, $attribute, $folder = 'section') use ($domain) {

            if (!empty($image)) {
                $mimeType = $image->getMimeType();
                if (in_array($mimeType, array_values(config('netgamer.scoped_image_types')))) {
                    $mimeTypes = collect(config('netgamer.scoped_image_types'))->flip()->toArray();
                    $extension = $mimeTypes[$mimeType];

                    if (!empty($section->$attribute)) {
                        $filename = $section->$attribute;
                    } else {
                        $filename = generate_upload_name() . '.' . $extension;
                    }

                    $fullPath = domain_upload_path($domain, 'storage/' . $folder) . $filename;
                    file_put_contents($fullPath, file_get_contents($image->getRealPath()));
                    $this->thumbs($fullPath, $folder);
                    $inputData[$attribute] = $filename;
                }
            }
        };

        if (!empty($inputData['image_remove'])) {
            self::deleteImage($section->image, 'section');
            unset($inputData['image_remove']);
        }

        if (!empty($inputData['image'])) {
            $saveImages($inputData, $inputData['image'], $section, 'image', 'section');
        }
    }

    public function thumbs($image, $folder)
    {
        /** @var Image $image */
        $fullPath = $image;

        $config = collect(config('image.thumb.' . $folder))->map(function ($item) {
            return [
                'size' => $item['size'],
                'generateImage' => true,
                'watermark' => false,
                'text' => false,
                'color' => null
            ];
        });

        $this->createThumbs($fullPath, $config, $folder);
    }
}
