<?php

namespace App\Traits;

use App\Helpers\Deployer\Classes\Deployer;
use App\Jobs\CopyContent;
use App\Models\{ArticleGroup,
    ArticleGroupArticle,
    ArticleStorageImage,
    ComplainOption,
    Domain,
    DomainMirror,
    DomainVolume,
    Modules\ModuleSlide,
    SectionStorageImage,
    Site as SiteModel,
    SiteStorageImage,
    SiteUser,
    Template,
    TemplateScheme,
    UserSite
};
use Auth;
use Cache;
use Curl;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Validator;

trait Site
{
    /**
     * @param $name
     * @param $domain
     * @param $user
     * @param null $parentDomain
     * @param bool $technicalSite
     * @param bool $domainMirror
     * @param array $data
     * @param bool $isPersonal
     * @return Model
     * @throws Exception
     */
    public static function createSite($name, $domain, $user, $parentDomain = null, $technicalSite = true,
                                      $domainMirror = false, $data = [], $isPersonal = false): Model
    {
        if (isset($data['template_id'])) {
            $template = Template::query()->find($data['template_id']);
            if (!$template) {
                $template = Template::whereDefault(1)->first();
            }
        } else {
            $template = Template::whereDefault(1)->first();
        }

        $templateScheme = TemplateScheme::default()->first();
        $siteParentId = ($parentDomain && $parentDomain->site) ?
            $parentDomain->site->id : null;

        if (!$templateScheme) {
            if (count($template->templateSchemes) > 0) {
                $templateScheme = $template->templateSchemes->random();
            } else {
                $templateScheme = TemplateScheme::all()->random();
            }
        }

        $siteRoot = null;

        if ($parentDomain) {
            $siteRoot = $parentDomain->site;

            if (!$siteRoot) {

                $siteRoot = SiteModel::firstOrCreate(['domain' => $parentDomain->name], [
                    'domain' => $parentDomain->name,
                    'domain_id' => $parentDomain->id,
                    'title' => $parentDomain->name,
                    'template_id' => $template->id,
                    'user_id' => $user->id,
                    'template_scheme_id' => $templateScheme->id
                ]);
            }

            $siteParentId = $siteRoot->id;
        }
        $site = SiteModel::query()->firstOrCreate(['domain' => $name], [
            'domain' => $name,
            'domain_id' => $domain->id,
            'title' => $data['title'] ?? $name,
            'template_id' => $template->id,
            'user_id' => $user->id,
            'template_scheme_id' => $templateScheme->id,
            'parent_id' => $siteParentId,
            'slogan' => $data['slogan'] ?? null,
        ]);

        if ($user) {
            SiteUser::query()->firstOrCreate(['user_id' => $user->id, 'site_id' => $site->id]);
        }

        if ($siteRoot) {
            $site->makeChildOf($siteRoot);
        }

        if ($domainMirror == true) {
            DomainMirror::query()->firstOrCreate(['domain_id' => $domain->id], [
                'domain_id' => $domain->id,
                'domain_mirror_id' => $parentDomain->id
            ]);
        }

        $job = (new CopyContent([$site], getenv('DOCUMENT_ROOT')))
            ->onConnection('redis')
            ->onQueue('copy_content');

        dispatch($job);

        if (!$domain->domainVolume) {
            $pvc = DomainVolume::createPvc();
            $domain->update([
                'domain_volume_id' => $pvc->id
            ]);
            $domain->refresh();
        }

        (new Deployer($name, $domain->domainVolume, $isPersonal, $data['customer_domain'] ?? ''))->v1();

        if ($technicalSite == true) {
            self::createTechnicalSite($site);
        }

        return $site;
    }

    /**
     * @param $site
     * @return bool
     * @throws Exception
     */
    public static function createTechnicalSite($site): bool
    {
        $technicalDomain = Domain::whereDomainType(Domain::DOMAIN_TYPE_SYSTEM)
            ->whereNull('parent_id')->get();

        if (count($technicalDomain) > 0) {
            $technicalDomain = $technicalDomain->random();
        } else {
            return false;
        }

        $domainParts = preg_split('/\./', idnToAscii($site->domain));

        $technicalName = slugify($domainParts[0]) . '.' . $technicalDomain->name;

        if (env('DEVELOPMENT') == true) {
            $env = 0;
        } else {
            $env = 1;
        }

        $pvc = DomainVolume::createPvc();

        $domain = Domain::firstOrCreate(['name' => $technicalName], [
            'environment' => $env,
            'parent_id' => $site->siteDomain->id,
            'name' => $technicalName,
            'domain_type' => Domain::DOMAIN_TYPE_SYSTEM,
            'language_id' => $site->siteDomain->language_id,
            'domain_thematic_id' => $site->siteDomain->domain_thematic_id,
            'user_id' => $site->user_id,
            'domain_volume_id' => $pvc->id
        ]);

        $technicalSite = SiteModel::firstOrCreate(['domain' => $technicalName], [
            'domain' => $technicalName,
            'domain_id' => $domain->id,
            'title' => slugify($technicalName),
            'template_id' => $site->template_id,
            'user_id' => $site->user_id,
            'template_scheme_id' => $site->template_scheme_id,
            'parent_id' => $site->id
        ]);

        DomainMirror::firstOrCreate([
            'domain_id' => $site->siteDomain->id,
            'domain_mirror_id' => $domain->id
        ]);

        $docRoot = getenv('DOCUMENT_ROOT');
        $job = (new CopyContent([$technicalSite], $docRoot))
            ->onConnection('redis')
            ->onQueue('copy_content');

        dispatch($job);

        (new Deployer($technicalName, $pvc))->v1();

        return true;
    }

    public static function createSiteValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'content' => 'required',
            'domain' => 'required|domain_exists|domain_valid',
            'parent_id' => 'required'
        ];

        $messages = [
            'title.required' => 'Напишите название',
            'content.required' => 'Тело сайта пустое',
            'title.max' => 'Название не должно быть больше 200 символов',
            'title.min' => 'Название должно быть не меньше 3 символов',
            'parent_id.required' => 'Вы не выбрали домен',
            'domain.required' => 'Url сайта обязателен для заполнения',
            'domain.domain_exists' => 'Домен не найден в нашей системе',
            'domain.domain_valid' => 'Домен невалидный'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createSiteUpdateValidator($data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'title' => 'required',
        ];

        $messages = [
            'title.required' => 'Напишите название',
            'title.max' => 'Название не должно быть больше 200 символов',
            'title.min' => 'Название должно быть не меньше 3 символов',
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createSiteBreadcrumbsValidator($data, $except = [], $customErrors = [],
                                                          $customMessages = [])
    {
        $default = [
            'breadcrumbs' => 'required',
        ];

        $messages = [
            'breadcrumbs.required' => 'Не заданы настройки хлебных крошек',
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function createDefaultRecords($site, $returnArray = false): ?array
    {
        $menu = [
            ['title' => 'Содержание сайта', 'url' => '/sections', 'site_id' => $site->id, 'alias' => 'sections', 'as_tree' => 1],
            ['title' => 'Статьи', 'url' => '/articles', 'site_id' => $site->id, 'alias' => 'articles'],
        ];

        foreach ($menu as $item) {
            \App\Models\Menu::create($item);
        }

        $section = \App\Models\Section::query()
            ->firstOrCreate(['site_id' => $site->id, 'title' => 'Содержание сайта', 'user_id' => $site->user_id]);

        ComplainOption::create(['title' => 'Список жалоб']);

        if ($returnArray == true) {
            return compact('section');
        }

        return null;
    }

    public static function copyContent($toSite)
    {

        if (env('DEVELOPMENT') == false) {
            $domain = config('netgamer.content_domain');
        } else {
            $domain = config('netgamer.content_domain_dev');
        }

        $fromSite = SiteModel::whereDomain($domain)->first();

        if (!$fromSite) {
            return false;
        }

        $mapData = [];
        $articles = [];

        $newSectionRoot = \App\Models\Section::roots()->bySite($toSite->id)->first();
        $fromSectionRoot = \App\Models\Section::roots()->bySite($fromSite->id)->first();
        $sections = $fromSectionRoot->getDescendants();
        $newSectionRootParent = null;

        $inputData = [
            'site_id' => $toSite->id
        ];

        if (count($sections) > 0) {

            foreach ($sections as $id => $sectionItem) {
                $parentId = null;

                $newSectionRootParent = self::createSectionCopy($newSectionRoot, $sectionItem, $inputData, true, $mapData);

                if (count($sectionItem->children) > 0) {
                    foreach ($sectionItem->children as $child) {
                        $newSection = SiteModel::createSectionCopy($newSectionRootParent, $child, $inputData, true, $mapData);

                        SiteModel::setChildren($newSection, $child, $inputData, true, $mapData);
                    }
                }
            }
        }

        if ($fromSectionRoot) {
            $articles = \App\Models\Article::whereSectionId($fromSectionRoot->id)
                ->where('site_id', $fromSectionRoot->site_id)->get();
        }

        if (count($articles) > 0) {
            foreach ($articles as $article) {

                $newArticle = static::createArticleCopy($article, $newSectionRoot, $inputData, true, $mapData);

                $articleGroup = ArticleGroup::whereArticleId($article->id)->first();

                if ($articleGroup) {
                    $articleGroupArticles = ArticleGroupArticle::whereArticleGroupId($articleGroup->id)->get();

                    $newArticleGroup = ArticleGroup::create([
                        'name' => $articleGroup->name,
                        'user_id' => Auth::user()->id,
                        'site_id' => $inputData['site_id'],
                        'article_id' => $newArticle->id
                    ]);

                    if (count($articleGroupArticles) > 0) {

                        foreach ($articleGroupArticles as $articleGroupArticle) {
                            if ($articleGroupArticle->article_id != $article->id) {

                                $newArticleFromGroup = static::createArticleCopy($articleGroupArticle->article, $newSectionRoot, $inputData, true, $mapData);
                            } else {
                                $newArticleFromGroup = $newArticle;
                            }

                            ArticleGroupArticle::create([
                                'article_id' => $newArticleFromGroup->id,
                                'article_group_id' => $newArticleGroup->id,
                                'name' => $articleGroupArticle->name,
                                'sort_order' => $articleGroupArticle->sort_order
                            ]);
                        }
                    }
                }

                static::createComments($article, $newArticle, $inputData);
            }
        }


        ModuleSlide::flushCache();

        return true;
    }

    public static function createSectionCopy($parentSection, $section, $inputData,
                                             $copyOnly = false, &$mapData = [])
    {

        $articles = \App\Models\Article::whereSectionId($section->id)->where('site_id', $section->site_id)->get();

        $newSection = \App\Models\Section::create([
            'title' => $section->title,
            'content' => $section->content,
            'content_short' => $section->content_short,
            'image' => $section->image,
            'site_id' => $parentSection->site_id,
            'parent_id' => $parentSection->id,
            'is_secret' => $section->is_secret,
            'is_private' => $section->is_private,
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'react_data' => $section->react_data
        ]);

        if (!empty($section->setting)) {
            $newSectionSetting = $section->setting->replicate();
            $newSectionSetting->section_id = $newSection->id;
            $newSectionSetting->save();
        }

        $mapData['sections'][$section->id] = $newSection->id;

        self::copyTags($section, $newSection);

        if (!empty($section->sectionStorageImages)) {
            foreach ($section->sectionStorageImages as $image) {
                SectionStorageImage::create([
                    'section_id' => $newSection->id,
                    'storage_file_id' => $image->storage_file_id
                ]);
            }
        }

        if (count($articles) > 0) {
            foreach ($articles as $article) {

                $newArticle = static::createArticleCopy($article, $newSection, $inputData, $copyOnly, $mapData);
                $articleGroup = ArticleGroup::whereArticleId($article->id)->first();


                if ($articleGroup) {
                    $articleGroupArticles = ArticleGroupArticle::whereArticleGroupId($articleGroup->id)->get();

                    $newArticleGroup = ArticleGroup::create([
                        'name' => $articleGroup->name,
                        'user_id' => $articleGroup->user_id,
                        'site_id' => $inputData['site_id'],
                        'article_id' => $newArticle->id
                    ]);

                    if (count($articleGroupArticles) > 0) {

                        foreach ($articleGroupArticles as $articleGroupArticle) {
                            if ($articleGroupArticle->article_id != $article->id) {

                                $newArticleFromGroup = static::createArticleCopy($articleGroupArticle->article,
                                    $newSection, $inputData, $copyOnly, $mapData);
                            } else {
                                $newArticleFromGroup = $newArticle;
                            }

                            ArticleGroupArticle::create([
                                'article_id' => $newArticleFromGroup->id,
                                'article_group_id' => $newArticleGroup->id,
                                'name' => $articleGroupArticle->name,
                                'sort_order' => $articleGroupArticle->sort_order
                            ]);
                        }
                    }
                }

                static::createComments($article, $newArticle, $inputData);
            }
        }

        return $newSection;
    }

    public static function copyTags($object, $newObject)
    {
        if (count($object->tags) > 0) {
            $tagArray = $object->tags->map(function ($tag) {
                return $tag->name;
            })->toArray();

            $newObject->tag($tagArray);
        }
    }

    public static function createArticleCopy($article, $newSection, $inputData, $copyOnly = false, &$mapData = [])
    {
        $articleData = [
            'title' => $article->title,
            'author_id' => Auth::user() ? Auth::user()->id : $article->author_id,
            'site_id' => $inputData['site_id'],
            'active' => $article->active,
            'section_id' => $newSection->id,
            'content' => $article->content,
            'content_short' => $article->content_short,
            'published_at' => $article->published_at,
            'draft' => $article->draft,
            'status' => $article->status,
            'slug' => $article->slug,
            'unpublished_at' => $article->unpublished_at,
            'settings' => $article->settings,
            'preview_hash' => '',
            'react_data' => $article->react_data,
            'hide_author' => $article->hide_author,
            'image' => $article->image,
            'images' => $article->images,
            'thumbs' => $article->thumbs,
            'views_cnt' => $article->views_cnt,
            'comments_cnt' => $article->comments_cnt
        ];

        $newArticle = \App\Models\Article::create($articleData);

        $mapData['articles'][$article->id] = $newArticle->id;

        self::copyTags($article, $newArticle);

        if (!empty($article->images)) {
            foreach ($article->images as $image) {
                ArticleStorageImage::create([
                    'article_id' => $newArticle->id,
                    'storage_file_id' => $image->storage_file_id
                ]);
            }
        }

        return $newArticle;
    }

    public static function createComments($article, $newArticle, $inputData)
    {


        $comments = \App\Models\Comment::whereObjectId($article->id)
            ->whereObject(\App\Models\Article::class)->get();


        if (count($comments) > 0) {

            foreach ($comments as $comment) {
                \App\Models\Comment::create([
                    'content' => $comment->content,
                    'react_data' => $comment->react_data,
                    'author_id' => $comment->author_id,
                    'moderator_id' => $comment->moderator_id,
                    'rating' => $comment->rating,
                    'object' => \App\Models\Article::class,
                    'object_id' => $newArticle->id,
                    'parent_id' => $comment->parent_id,
                    'moderated' => $comment->moderated,
                    'status' => $comment->status,
                    'top' => $comment->top,
                    'site_id' => $inputData['site_id'],
                    'pinned' => $comment->pinned
                ]);
            }
        }
    }

    public static function setChildren($parentSection, $section, $inputData, $copyOnly = false, $mapData = [])
    {
        if (count($section->children) > 0) {
            foreach ($section->children as $child) {
                $newSection = self::createSectionCopy($parentSection, $child, $inputData, $copyOnly, $mapData);
                self::setChildren($newSection, $child, $inputData, $copyOnly, $mapData);
            }
        }
    }

    public static function ssr()
    {
        $user = Auth::user();
        $path = request()->path();
        $port = env('DEVELOPMENT') == true ? 3000 : 4000;
        $httpPrefix = getSchema();
        $host = $httpPrefix . "localhost:{$port}/";

        if (env('APP_DEBUG_VARS') == true) {
            debugvars('SSR DOMAIN: ' . env('DOMAIN'));
        }

        $permissions = [];

        if ($user) {
            $site = get_site();
            $permissions = permissions($user, false, null, get_class($site));
        }

        $data = [
            'theme' => session('theme'),
            'domain' => $httpPrefix . env('DOMAIN'),
            'user' => $user?->toArray(),
            'permissions' => $permissions
        ];

        $headers = [
            'accept' => '*/*',
            'accept-language' => 'en-US,en;q=0.8',
            'content-type' => 'application/json'
        ];

        return Curl::to($host . ($path == "/" ? "" : $path))->withData($data)->asJson()
            ->withHeaders($headers)->allowRedirect()
            ->withOption('HTTP_VERSION', CURL_HTTP_VERSION_1_1)
            ->withOption('COOKIE', http_build_query($_COOKIE, '', '; '))->post();
    }

    public static function getSiteCacheKey()
    {
        return SiteModel::class . '.' . env('DOMAIN');
    }

    public static function getSiteMedia($site, $type = SiteStorageImage::LOGO): array
    {
        $image = SiteStorageImage::whereSiteId($site->id)->where('type', $type)
            ->remember(config('app.remember_time'))->first();

        if ($image && $image->storageFile) {

            return [
                'id' => $image->storageFile->id,
                'title' => $image->storageFile->title,
                'description' => $image->storageFile->description,
                'thumbs' => $image->storageFile->thumbs,
                'url' => $image->storageFile->url . DS . $image->storageFile->filename
            ];
        }

        return [];
    }

    public function faviconUrlV2(): array
    {
        $thumbs = [];
        $image = SiteStorageImage::whereSiteId($this->id)->whereNull('deleted_at')
            ->where('type', SiteStorageImage::FAVICON)->remember(config('app.remember_time'))->first();
        if ($image) {
            foreach (config('image.thumb.favicon') as $item) {

                $width = $item['size'][0];
                $height = $item['size'][1];
                $size = "{$width}x{$height}";

                $thumbs["thumb{$size}"] = $this->imageUrl($size, 'favicon',
                    $image->storageFile->filename);
            }
            $thumbs['original'] = $image->storageFile->url . DS . $image->storageFile->filename;
            $thumbs['id'] = $image->storageFile->id;
        }

        return $thumbs;
    }

    public function setSiteRoot()
    {
        $root = SiteModel::root();

        if (!$root) {
            $domainName = env('DEFAULT_DOMAIN');

            $domain = Domain::where('name', $domainName)->get()->first();
            $template = Template::whereDefault(1)->get()->first();

            if (!$domain) {
                $domain = Domain::create([
                    'name' => $domainName,
                    'domain_type' => Domain::DOMAIN_TYPE_THEMATIC,
                    'is_default' => 1,
                    'default' => 0
                ]);
            }

            SiteModel::create([
                'title' => $domainName,
                'domain' => $domainName,
                'domain_id' => $domain->id,
                'template_id' => $template->id
            ]);

            $root = SiteModel::root();
        }

        return $root;
    }

    /**
     * @param $term
     * @return mixed
     */
    public function siteSlug($term)
    {
        $slug = $data['slug'] = slugify($term, false);
        $data['domains'] = [];

        if (mb_strlen($slug) < 4) {
            return $this->error('Имя сайта должно быть не меньше 4 символов');
        } elseif (mb_strlen($slug) > 63) {
            return $this->error('Имя сайта должно быть меньше 63 символов');
        } else {

            $domains = Domain::thematic()->own()
                ->whereHideFromRegistration(0)->byLanguage()
                ->roots()->orderBy('name', 'asc')->get(['name', 'parent_id', 'id', 'language_id']);

            if (count($domains) > 0) {

                $domains = $domains->filter(function ($domain) use ($slug) {
                    $domainWithSlug = $slug . '.' . $domain->name;
                    $foundDomain = Domain::where('name', $domainWithSlug)->first();

                    if (!$foundDomain) {
                        return true;
                    } else {
                        return false;
                    }
                });

                if (count($domains) > 0) {
                    $domains = $domains->makeHidden(['id', 'domain_thematic_id']);
                }

                $foundLongDomain = null;

                $data['domains'] = $domains->values()->map(function ($domain)
                use ($slug, &$foundLongDomain) {
                    $domain['parent_id'] = $domain['id'];
                    $domainWithSlug = $slug . '.' . $domain['name'];

                    if (mb_strlen($domainWithSlug) > 255) {
                        $foundLongDomain = true;
                    }
                    return $domain;
                });

                if ($foundLongDomain) {
                    return $this->error('Длина всего сайта не должна быть больше 255 символов');
                }
            }
        }

        return $data;
    }

    public function getSite($domain, $siteModel = SiteModel::class)
    {
        return $this->getSiteCache($domain, $siteModel);
    }

    private function getSiteCache($domain, $siteModel)
    {
        $key = $siteModel . '.' . $domain;
        $site = Cache::get($key);

        if (!$site) {

            $site = $siteModel::whereDomain($domain)->first();

            if ($site) {
                remember($key, function () use ($site) {
                    return $site;
                });
            }
        }

        return $site;
    }

    public function siteSettings(): array
    {
        $data = [];
        foreach ($this->fillable as $field) {
            if (strstr($field, 'filter_')) {
                $data[$field] = $this->$field;
            }
        }

        $data['articles_description'] = $this->articles_description;

        return $data;
    }

    protected function getAuthSites($user = null)
    {
        $sites = collect();
        if ($user) {
            $userSites = UserSite::where(['user_id' => $user->id])->with(['site', 'domain'])
                ->get(['site_id', 'domain_id']);

            foreach ($userSites as $userSite) {
                if ($userSite->site) {
                    $sites[] = main_domain($userSite->site->domain);
                }
                if ($userSite->domain) {
                    $sites[] = main_domain($userSite->domain->name);
                }
            }

            $sites = collect($sites);
        }

        $currentSite = $sites->search(env('DOMAIN'));

        if ($currentSite) {
            $sites = $sites->except($currentSite);
        }

        return $sites;
    }

    private function getSites(): array
    {
        $sites = [];

        $repeat = function ($item) {
            return (int)$item['depth'] > 1 ? str_repeat('&#8735;', round($item['depth'] / ($item['depth'] + 0.9))) : null;
        };

        $nodes = self::getSiteNodes(\App\Models\Site::root(), false);

        if ($nodes) {
            foreach ($nodes->toArray() as $item) {
                $item['domain'] = sprintf('%s %s',
                    str_repeat('&nbsp;', abs($item['depth'] * 3 - 1)) . $repeat($item), //'&#8212; 8211'
                    $item['domain']
                );

                $sites[$item['id']] = $item['domain'];
            }
        }

        return $sites;
    }

    private static function getSiteNodes($site, $withRoot)
    {
        $siteRoots = $site;
        $nodes = [];

        if ($siteRoots) {
            $node = $siteRoots->get()->first();
            $nodes = Utils::nodes($node, $withRoot);
        }

        return $nodes;
    }

}
