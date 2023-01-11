<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\Deployer\Classes\Deployer;
use App\Models\Domain;
use App\Models\Section;
use App\Models\Site;
use App\Models\SiteStorageImage;
use App\Models\SiteUser;
use App\Models\Template;
use App\Models\TemplateScheme;
use App\Models\User;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use App\Traits\Site as SiteTrait;
use App\Traits\Utils;
use App\Utils\CmsFilter;
use Cache;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use ImagickException;
use Intervention\Image\Image;
use Session;
use Validator;

class SitesController extends CmsController
{
    use DomainTrait;
    use CustomValidators;
    use Utils;
    use Media;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Сайты', 'sites.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index(): Factory|Response|View|Application
    {
        $title = 'Сайты';

        $breadcrumbs = $this->breadcrumbs;

        $root = $this->setSiteRoot();

        $sites = Site::withTrashed()->whereHidden(0);

        $fields = $this->setFields($sites);

        $filter = new CmsFilter(Site::class, 'sites.index');

        $filter->addField('title', 'Название')
            ->addField('domain', 'Домен')
            ->addField('created_at', 'Дата создания')
            ->addButton('Создать', 'sites.create');

        $filter = $filter->render();

        $request = request()->all();

        $order = null;
        if (isset($request['ord']) || isset($request['page'])) {
            $order = true;
        }

        Site::rebuild();
        $treeData = Site::withTrashed()->whereHidden(0)->get()->toHierarchy();

        return view('cms.sites.index',
            compact('fields', 'title', 'filter', 'breadcrumbs', 'root', 'order', 'sites', 'treeData'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $title = 'Создать';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Site();
        $action = 'sites.store';

        $treeOptions = Site::getTreeOptions(null, true);

        $templates = Template::with('sites')->get();

        $templatesSelect = [null => 'Выберите шаблон...'];

        foreach ($templates as $template) {
            $templatesSelect[$template->id] = $template->name . ' (' . $template->alias . ')';
        }

        $defaultSchemes = TemplateScheme::defaultSchemes()
            ->orderBy('default_global', 'DESC')->get()
            ->pluck('name', 'id')->toArray();

        if (!empty($defaultSchemes)) {
            $templateSchemes = [null => 'Выберите цветовую схему...'] + $defaultSchemes;
        }

        $users = User::selectOptions(null, true);
        $domains = Domain::query()->get()->pluck('name', 'name')->toArray();

        $domains = array_map(function ($domain) {
            return idnToUtf8($domain);
        }, $domains);

        $exceptDomains = Site::query()->get(['domain'])->pluck('domain')->toArray();

        if (!empty($exceptDomains)) {
            $domains = collect($domains)->except($exceptDomains);
        }

        return view('cms.sites.new_form', compact('form', 'title', 'breadcrumbs', 'action',
            'treeOptions', 'users', 'templatesSelect', 'templateSchemes', 'domains'));
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

            if (empty($inputData['template_scheme_id'])) {
                $scheme = TemplateScheme::where('default_global', 1)->first();
                if ($scheme) {
                    $inputData['template_scheme_id'] = $scheme->id;
                } else {
                    $scheme = TemplateScheme::inRandomOrder()->limit(1)->first();
                    $inputData['template_scheme_id'] = $scheme->id;
                }
            }

            if (!isset($inputData['parent'])) {
                $inputData['parent'] = null;
            }

            $inputData['parent_id'] = $inputData['parent'];

            unset($inputData['_token'], $inputData['parent']);

            $dataExceptImages = collect($inputData)->except(['image', 'favicon', 'logo', 'site_header'])->toArray();

            $site = Site::firstOrCreate($dataExceptImages, $dataExceptImages);

            $this->processImages($inputData, $site);

            $site->update($inputData);

            $domain = Domain::whereName(idnToAscii($site->domain))->first();

            $inputData['domain_id'] = $domain->id;
            $inputData['domain'] = strtolower(idnToAscii($site->domain));

            if (!isset($inputData['show_article_rating'])) {
                $inputData['show_article_rating'] = 0;
            }

            if (!isset($inputData['show_article_author'])) {
                $inputData['show_article_author'] = 0;
            }

            if (!isset($inputData['show_section_rating'])) {
                $inputData['show_section_rating'] = 0;
            }

            if (!isset($inputData['hide_article_author_inside'])) {
                $inputData['hide_article_author_inside'] = 0;
            }

            $site->update($inputData);

            if (!empty($inputData['user_id'])) {
                SiteUser::firstOrCreate([
                    'user_id' => $inputData['user_id'],
                    'site_id' => $site->id
                ]);
            }

            $this->updateSiteSettings($site);

            reloadSite($site);

            forget(SiteTrait::getSiteCacheKey());

            forget('settings.' . env('DOMAIN'));

            SiteStorageImage::flushCache();

            if (!$site->template) {
                $site->setTemplate();
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('sites.index');
        }
    }

    public static function getValidator($data, $onUpdate = false)
    {
        if (!$onUpdate) {
            $domainRule = 'required|domain_exists|domain_valid|unique:site';
        } else {
            $domainRule = 'required|domain_exists|domain_valid';
        }

        $rules = [
            'title' => 'required',
            'domain' => $domainRule
        ];

        $messages = [
            'title.required' => 'Напишите название',
            'domain.required' => 'Напишите домен',
            'domain.domain_exists' => 'Такой домен не сущеcтвует. Добавьте домен.',
            'domain.domain_valid' => 'Невалидный домен',
            'domain.unique' => 'Такой домен уже есть в системе'
        ];

        return Validator::make($data, $rules, $messages);
    }

    public function processImages(&$inputData, $site)
    {
        $domain = $site->depth > 1 ? $site->getMainDomain() : idnToAscii($site->domain);

        /**
         * @param $inputData
         * @param $image
         * @param $site
         * @param string $folder
         * @param $attribute
         */
        $saveImages = function (&$inputData, $image, $site, $attribute, $folder = 'site_preview') use ($domain) {

            if (!empty($image) && $image->isValid()) {
                $mimeType = $image->getMimeType();

                if (in_array($mimeType, array_values(config('netgamer.scoped_image_types')))) {
                    $mimeTypes = collect(config('netgamer.scoped_image_types'))->flip()->toArray();
                    $extension = $mimeTypes[$mimeType];

                    if (!empty($site->$attribute)) {
                        $filename = $site->$attribute;
                    } else {
                        $filename = generate_upload_name() . '.' . $extension;
                    }

                    $fullPath = domain_upload_path($domain, 'storage/' . $folder) . $filename;

                    file_put_contents($fullPath, file_get_contents($image->getRealPath()));
                    $this->thumbs($fullPath, $folder);
                    $inputData[$attribute] = $filename;
                }
            } else {
                if (env('APP_DEBUG_VARS') == true) {
                    debugvars($image->getErrorMessage());
                }
            }

        };

        if (!empty($inputData['logo'])) {
            self::deleteImage($site->logo, 'site_logo');
        }

        if (!empty($inputData['image'])) {
            self::deleteImage($site->image, 'site_preview');
        }

        if (!empty($inputData['favicon'])) {
            self::deleteImage($site->favicon, 'favicon');
        }

        if (!empty($inputData['site_header'])) {
            self::deleteImage($site->site_header, 'site_header');
        }

        if (!empty($inputData['image'])) {
            $saveImages($inputData, $inputData['image'], $site, 'image', 'site_preview');
        }
        if (!empty($inputData['site_header'])) {
            $saveImages($inputData, $inputData['site_header'], $site, 'site_header', 'site_header');
        }
        if (!empty($inputData['favicon'])) {
            $saveImages($inputData, $inputData['favicon'], $site, 'favicon', 'favicon');
        }
        if (!empty($inputData['logo'])) {
            $saveImages($inputData, $inputData['logo'], $site, 'logo', 'site_logo');
        }

        $nullableImages = [];

        if (!empty($inputData['logo_remove'])) {

            $nullableImages = array_merge($nullableImages, ['logo' => null]);
            unset($inputData['logo_remove']);
        }

        if (!empty($inputData['image_remove'])) {
            $nullableImages = array_merge($nullableImages, ['image' => null]);
            unset($inputData['image_remove']);
        }

        if (!empty($inputData['favicon_remove'])) {

            $nullableImages = array_merge($nullableImages, ['favicon' => null]);
            unset($inputData['favicon_remove']);
        }

        if (!empty($inputData['site_header_remove'])) {
            $nullableImages = array_merge($nullableImages, ['site_header' => null]);
            unset($inputData['site_header_remove']);
        }

        if (!empty($nullableImages)) {
            $site->update($nullableImages);
        }
    }

    /**
     * @param $image
     * @param $folder
     * @throws ImagickException
     */
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
    public function edit($id)
    {
        $title = 'Редактирование';

        $form = Site::find($id);

        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'sites.update';

        $treeOptions = Site::getTreeOptions(null, true);

        if ($id) {
            unset($treeOptions[$id]);
        }

        $templates = Template::with('sites')->get();

        $templatesSelect = [null => 'Выберите шаблон...'];

        foreach ($templates as $template) {
            $templatesSelect[$template->id] = $template->name . ' (' . $template->alias . ')';
        }

        $defaultSchemes = TemplateScheme::defaultSchemes()
            ->orderBy('default_global', 'DESC')->get()
            ->pluck('name', 'id')->toArray();

        if (!empty($defaultSchemes)) {
            $templateSchemes = [null => 'Выберите цветовую схему...'] + $defaultSchemes;
        }

        $users = User::selectOptions(null, true);

        if ($form->siteDomain && $form->siteDomain->domain_type == Domain::DOMAIN_TYPE_PERSONAL) {
            $domains = Domain::where('name', $form->domain)->get()->pluck('name', 'name')->toArray();
        } else {
            $domains = Domain::get()->pluck('name', 'name')->toArray();
        }

        $domains = array_map(function ($domain) {
            return idnToUtf8($domain);
        }, $domains);

        return view('cms.sites.edit', compact('form', 'title', 'breadcrumbs', 'action', 'treeOptions', 'templatesSelect', 'templateSchemes', 'users', 'domains'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function update(Request $request, int $id): Response|RedirectResponse
    {
        /**
         * TODO Беда! Надо рефакторить. Пока всё сломается.
         */

        $site = Site::find($id);
        $inputData = $request->all();

        if (isset($inputData['domain']) && $inputData['domain'] != idnToAscii($site->domain)
            && $this->domainValid($inputData['domain'])) {

            $siteExists = Site::where('domain', $inputData['domain'])->first();

            if ($siteExists) {
                return redirect()->back()
                    ->withInput($inputData)->withErrors('Такой сайт с доменом уже существует');
            }

            $domain = Domain::where('name', idnToAscii($site->domain))->first();

            if ($domain) {

                (new Deployer($inputData['domain'], $domain->domainVolume))->v1();
                $oldDomain = $domain->name;
                $domain->update(['name' => $inputData['domain']]);
                Deployer::uninstall($oldDomain);
            }
        }

        $validator = static::getValidator($inputData, true);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $section = Section::where(['site_id' => $site->id, 'parent_id' => null])->get()->first();

            if (!$section) {
                Section::create(['site_id' => $site->id, 'title' => 'Разделы', 'path' => '/', 'slug' => 'root']);
            }

            if (empty($inputData['template_scheme_id'])) {
                $scheme = TemplateScheme::where('default_global', 1)->get()->first();
                if ($scheme) {
                    $inputData['template_scheme_id'] = $scheme->id;
                } else {
                    $scheme = TemplateScheme::inRandomOrder()->limit(1)->first();
                    $inputData['template_scheme_id'] = $scheme->id;
                }
            }

            $this->processImages($inputData, $site);

            if (!empty($inputData['user_id'])) {
                SiteUser::firstOrCreate([
                    'user_id' => $inputData['user_id'],
                    'site_id' => $site->id
                ]);
            }

            if (!empty($inputData['parent'])) {
                $inputData['parent_id'] = $inputData['parent'];
            } else {
                $inputData['parent_id'] = null;
            }

            unset($inputData['parent'], $inputData['_token']);

            if (!isset($inputData['show_article_rating'])) {
                $inputData['show_article_rating'] = 0;
            }

            if (!isset($inputData['show_article_author'])) {
                $inputData['show_article_author'] = 0;
            }

            if (!isset($inputData['show_section_rating'])) {
                $inputData['show_section_rating'] = 0;
            }

            if (!isset($inputData['hide_article_author_inside'])) {
                $inputData['hide_article_author_inside'] = 0;
            }

            $site->update($inputData);

            if (!$site->template) {
                $site->setTemplate();
            }

            $this->updateSiteSettings($site);

            forget(Site::class . '.' . idnToAscii($site->domain));
            forget('settings.' . idnToAscii($site->domain));

           reloadSite($site);

            forget(SiteTrait::getSiteCacheKey());

            forget('settings.' . env('DOMAIN'));

            SiteStorageImage::flushCache();

            session()->flash('success', 'Запись сохранена');
            return redirect()->route('sites.index');
        }
    }

    public function updateTree(Request $request): RedirectResponse
    {
        parent::saveTree($request, Site::class);
        session()->flash('success', 'Запись сохранена');
        return redirect()->route('sites.index');
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
        $site = Site::find($id);

        $foundPersonal = User::where('domain', 'like', '%' . idnToAscii($site->domain) . '%')->first();

        if ($foundPersonal) {
            return redirect()
                ->route('sites.index')
                ->with('error', 'Нельзя удалить персональный сайт с пользователями!');
        }

        if ($site->siteDomain && $site->siteDomain->domain_type == Domain::DOMAIN_TYPE_SYSTEM) {
            return redirect()
                ->route('sites.index')
                ->with('error', 'Нельзя удалить системный сайт!');
        }

        if (count($site->sections()->whereNotNull('parent_id')->get())) {
            return redirect()
                ->route('sites.index')
                ->with('error', 'Нельзя удалить сайт если у него есть разделы!');
        }

        if ($site->articles()->withTrashed()->count() > 0) {
            return redirect()
                ->route('sites.index')
                ->with('error', 'Нельзя удалить сайт если у него есть статьи!');
        }

        $siteChildren = $site->children()->withTrashed();

        if ($siteChildren->count() > 0) {
            foreach ($siteChildren->get() as $siteChild) {
                if (in_array($siteChild->siteDomain->domain_type,
                    [Domain::DOMAIN_TYPE_THEMATIC, Domain::DOMAIN_TYPE_PERSONAL])) {
                    return redirect()
                        ->route('sites.index')
                        ->with('error', 'Нельзя удалить сайт если у него есть подсайты!');
                }
            }
        }

        if ($site->siteDomain && $site->siteDomain->domain_type == Domain::DOMAIN_TYPE_PERSONAL) {
            $site->forceDelete();
        } else {
            Cache::forget(SiteTrait::getSiteCacheKey());
            $site->delete();
        }

        session()->flash('success', 'Запись удалена!');

        return redirect()->route('sites.index');
    }

    public function destroyForever($id)
    {
        $site = Site::withTrashed()->find($id);

        if ($site) {
            forget(Site::class . '.' . idnToAscii($site->domain));
            forget('settings.' . idnToAscii($site->domain));

            if ($site->siteDomain && !empty($site->siteDomain->user_id)) {
                $this->deleteDomain($site->siteDomain);
                $site->siteDomain()->delete();
            }
            $site->forceDelete();
        }

        return redirect()
            ->route('sites.index')
            ->with('notice', 'Сайт полностью удален!');
    }

    public function destroyCascade($id): RedirectResponse
    {
        $site = Site::withTrashed()->find($id);

        if (!$site) {
            return redirect()
                ->route('sites.index')
                ->with('notice', 'Сайт уже удален');
        }

        $allSites = $site->getDescendantsAndSelf()->toHierarchy()->toArray();

        if (empty($allSites)) {

            self::deleteDomain($site->siteDomain);

            forget(Site::class . '.' . idnToAscii($site->domain));
            forget('settings.' . idnToAscii($site->domain));

            $siteName = idnToAscii($site->domain);
            $site->forceDelete();

            try {
                Domain::whereName($siteName)->delete();
            } catch (Exception $e) {
                debugvars('Невозомжно удалить домен');
            }
        }

        function buildTree(array $elements, &$ids = []): array
        {
            foreach ($elements as $element) {
                $ids[] = $element['id'];

                if ($element['children']) {
                    buildTree($element['children'], $ids);
                }
            }

            return $ids;
        }

        if (!empty($allSites)) {
            $tree = buildTree($allSites);

            if (!empty($tree)) {
                foreach ($tree as $i => $id) {
                    $site = Site::withTrashed()->find($id);

                    self::deleteDomain($site->siteDomain);

                    forget(Site::class . '.' . idnToAscii($site->domain));
                    forget('settings.' . idnToAscii($site->domain));

                    $siteName = idnToAscii($site->domain);
                    $site->forceDelete();

                    try {
                        Domain::whereName($siteName)->delete();
                    } catch (Exception $e) {
                        if (env('APP_DEBUG_VARS') == true) {
                            debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
                        }
                    }
                }
            }
        }

        return redirect()
            ->route('sites.index')
            ->with('notice', 'Сайт полностью удален!');
    }

    public function undelete($id)
    {
        $site = Site::withTrashed()->find($id);
        $site?->restore();

        forget(Site::class . '.' . idnToAscii($site->domain));
        forget('settings.' . idnToAscii($site->domain));
        forget(Site::class . '.' . idnToAscii($site->domain) . '.deleted');

        return redirect()
            ->route('sites.index')
            ->with('success', 'Сайт полностью восстановлен!');
    }

    protected function makeRowsRecursive($data, $depth = 0)
    {
        $rows = [];
        foreach ($data as $item) {
            $item->children = $this->makeRowsRecursive($item['children'], $depth + 1);
            $rows[] = $item;
        }
        return $rows;
    }
}
