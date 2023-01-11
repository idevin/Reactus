<?php

namespace App\Providers;

use App\Cacher\Classes\Base\BaseItem;
use App\Cacher\Classes\Base\ModelHandler;
use App\Cacher\Event\Subscription;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\ArticleGroupArticle;
use App\Models\ArticleImage;
use App\Models\ArticleRevision;
use App\Models\ArticleStorageImage;
use App\Models\Comment;
use App\Models\Complain;
use App\Models\Domain;
use App\Models\DomainMirror;
use App\Models\DomainVolume;
use App\Models\Field;
use App\Models\FieldValue;
use App\Models\LanguageObject;
use App\Models\Modules\Module;
use App\Models\Modules\ModuleAnimationSettings;
use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleCatalog;
use App\Models\Modules\ModuleComment;
use App\Models\Modules\ModuleCompetitiveAdvantages;
use App\Models\Modules\ModuleContacts;
use App\Models\Modules\ModuleFeedback;
use App\Models\Modules\ModuleInformation;
use App\Models\Modules\ModuleMenu;
use App\Models\Modules\ModuleSection;
use App\Models\Modules\ModuleSlide;
use App\Models\Modules\ModuleSlider;
use App\Models\Modules\ModuleSocials;
use App\Models\Modules\ModuleStatistics;
use App\Models\Modules\ModuleText;
use App\Models\Role;
use App\Models\Section;
use App\Models\SectionSetting;
use App\Models\SectionStorageImage;
use App\Models\Site;
use App\Models\SiteStorageImage;
use App\Models\StorageFile;
use App\Models\Template;
use App\Models\User;
use App\Observers\UserObserver;
use App\Traits\CustomValidators;
use App\Traits\DefaultModuleSettings;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use Cache;
use Carbon\Carbon;
use DB;
use Exception;
use File;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Request;
use Session;

class AppServiceProvider extends ServiceProvider
{
    use \App\Traits\SectionSetting;
    use Media;
    use CustomValidators;
    use DomainTrait;
    use DefaultModuleSettings;

    public static int $requestHit = 5;

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function boot()
    {
        User::observe(UserObserver::class);

        self::setlocale();

        $this->customValidators();

        static::domain();
        static::site();
        static::article();
        static::comment();
        static::field();
        static::section();
        self::articleImage();
        static::module();
        static::role();
        static::user();

        $arHandlerClassList = Subscription::subscribe();
        foreach ($arHandlerClassList as $sClassHandler) {
            /** @var ModelHandler $obHandler */
            $obHandler = app()->make($sClassHandler);
            /** @var BaseItem $sItemClass */
            $sItemClass = $obHandler->getItemClass();
            if (empty($sItemClass)) {
                continue;
            }

            $sModelClass = $sItemClass::getModelClass();
            if (empty($sModelClass)) {
                continue;
            }

            try {
                $sModelClass::observe($sClassHandler);
            } catch (Exception $e) {
                continue;
            }
        }

        if (php_sapi_name() !== 'cli') {
            static::getTemplate();
            session(['domain' => env('DOMAIN')]);
        }

        $mainPath = env('APP_DIR') . DS . 'app' . DS . 'Database' . DS . 'Migrations';
        $directories = glob($mainPath . '/*', GLOB_ONLYDIR);
        $this->loadMigrationsFrom(array_merge([$mainPath], $directories));

        if ((int)env('APP_DB_LOG') == 1) {
            DB::listen(function ($query) {

                $driverName = $query->connection->getConfig()['driver'];
                if (!in_array($driverName, config('database.exclude_from_debug'))) {

                    $sql = Str::replaceArray('?', $query->bindings, $query->sql);

                    debugvars($sql, [
                        'time' => $query->time,
                        'path' => Request::path(),
                        'query' => $query->bindings,
                    ]);
                }
            });
        }
    }

    private static function setlocale()
    {
        Carbon::setLocale(config('app.locale'));
    }

    public static function domain()
    {
        Domain::deleting(function ($domain) {

            $domainClass = new class {
                use DomainTrait;
            };

            $domainClass->deleteDomain($domain);

            $mirror = DomainMirror::orWhere('domain_id', $domain->id)
                ->orWhere('domain_mirror_id', $domain->id)->first();

            if ($mirror) {
                $mirror->delete();
            }

            DomainVolume::deletePvc($domain->domain_volume_id);
        });

        Domain::creating(function ($domain) {
            $domain->name = idnToAscii($domain->name);
        });

        Domain::updating(function ($domain) {
            $domain->name = idnToAscii($domain->name);
        });
    }

    private static function site()
    {
        Site::updated(function ($site) {

            Session::put(Site::class . '.' . idnToAscii($site->domain), $site);

            self::deleteImageFiles();
        });

        Site::created(function ($site) {

            Session::put(Site::class . '.' . idnToAscii($site->domain), $site);

            self::createDefaultRecords($site);
            self::deleteImageFiles();
        });

        Site::creating(function ($site) {
            $site->domain = idnToAscii($site->domain);
        });

        Site::updating(function ($site) {
            $site->domain = idnToAscii($site->domain);
        });
    }

    public static function deleteImageFiles()
    {
        $files = null;
        $found = null;

        $storageFiles = StorageFile::withTrashed();

        if (Auth::user() && php_sapi_name() != 'cli') {
            $storageFiles = $storageFiles->byUser(Auth::user()->id)->get();
        } else {
            $storageFiles = $storageFiles->get();
        }

        if (count($storageFiles) > 0) {

            $files = $storageFiles->map(function ($file) {
                if ($file->trashed()) {
                    return $file;
                }
                return null;
            })->filter();

            $fileIds = $files->pluck('id')->toArray();

            $found = ArticleStorageImage::withTrashed()->whereIn('storage_file_id',
                array_values($fileIds))->get(['storage_file_id'])->pluck(['storage_file_id']);

            if (empty($found)) {
                $found = $found->merge(SiteStorageImage::withTrashed()->whereIn('storage_file_id',
                    array_values($fileIds))->get(['storage_file_id'])->pluck(['storage_file_id']));
            }
            if (empty($found)) {
                $found = $found->merge(SectionStorageImage::withTrashed()->whereIn('storage_file_id',
                    array_values($fileIds))->get(['storage_file_id'])->pluck(['storage_file_id']));
            }

            $found = $found->values()->unique()->toArray();

            if (!empty($found) && Auth::user() && php_sapi_name() != 'cli') {
                $toDelete = array_values(array_diff($fileIds, $found));
                $oStorageFiles = StorageFile::withTrashed()->whereIn('id', $toDelete);
                $storageFiles = $oStorageFiles->get();

                if (count($storageFiles) > 0) {

                    $storageFiles->map(function ($file) {
                        $fullPath = $file->path;

                        if (!empty($fullPath)) {
                            File::delete($fullPath);
                        }
                    });

                    $oStorageFiles->forceDelete();
                }
            }

            SiteStorageImage::flushCache();
        }
    }

    public static function article()
    {
        Article::creating(function ($article) {

            if (empty($article->slug)) {
                $article->slug = slugify($article->title);
            }

            if (empty($article->published_at)) {
                $article->published_at = Carbon::now();
            }
        });

        Article::updating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = slugify($article->title);
            }
        });

        Article::created(function ($article) {
            if (php_sapi_name() != 'cli') {

                if ($article->isStatusPublished()) {
                    $section = $article->section;

                    $ids = $section->getAncestorsAndSelfWithoutRoot()->pluck('id')->toArray();
                    DB::table('section')->whereIn('id', $ids)->increment('articles_cnt');
                }

                self::deleteImageFiles();
            }
        });

        Article::updated(function ($article) {

            if (php_sapi_name() != 'cli') {
                if ($article->isStatusPublished()) {

                    $section = $article->section;

                    if ($section) {

                        $oldCnt = $section->articles_cnt;
                        $newCnt = $article->section->articles()->count();

                        $delta = $newCnt - $oldCnt;

                        if (!empty($section->parent_id)) {

                            $ancestors = $section->getAncestorsAndSelfWithoutRoot();

                            if (count($ancestors) > 0) {

                                $ids = $ancestors->pluck('id')->toArray();
                                $qb = DB::table('section')->whereIn('id', $ids);

                                if ($delta > 0) {
                                    $qb->increment('articles_cnt', abs($delta));
                                } else {
                                    $qb->decrement('articles_cnt', abs($delta));
                                }
                            }
                        }
                        $section->rating = Section::calculateRating($section);
                        $section->update();
                    }
                }

                self::deleteImageFiles();
            }
        });

        Article::deleting(function ($article) {

            $complains = Complain::where([
                'object_id' => $article->id,
                'object' => Article::class
            ]);

            if (!empty($complains)) {
                $complains->delete();
            }

            $comments = Comment::where([
                'object_id' => $article->id,
                'object' => Article::class
            ]);

            if (!empty($comments)) {
                $comments->delete();
            }

            $articleGroupArticle = ArticleGroupArticle::whereArticleId($article->id);
            if ($articleGroupArticle) {
                $articleGroupArticle->delete();
            }

            ArticleRevision::where(['article_id' => $article->id])->delete();
            Comment::where(['object' => Article::class, 'object_id' => $article->id])->delete();
            Complain::where(['object' => Article::class, 'object_id' => $article->id])->delete();

            Announcement::where(['object_type' => Article::class, 'object_id' => $article->id])
                ->orWhere(['announce_type' => Article::class, 'announce_id' => $article->id])->delete();

            LanguageObject::whereObjectType(Article::class)->whereObjectId($article->id)->delete();
            ModuleSlide::whereArticleId($article->id)->delete();

            if ($article->isStatusPublished() || true) {
                $section = $article->section;
                if ($section && $section->articles_cnt > 0) {
                    $ids = $section->getAncestorsAndSelfWithoutRoot()
                        ->where('articles_cnt', '>', 0)->pluck('id')->toArray();

                    DB::table('section')->whereIn('id', $ids)->decrement('articles_cnt');
                }
            }

            LanguageObject::whereObjectId($article->id)->whereObjectType(Article::class)
                ->delete();

        });
    }

    public static function comment()
    {
        Comment::deleting(function (Comment $comment) {
            $complains = Complain::where('object_id', $comment->id)->where('object', Comment::class);

            if (!empty($complains)) {
                $complains->delete();
            }

            $sections = Section::where('last_comment_id', $comment->id)->get();

            if (count($sections) > 0) {
                foreach ($sections as $section) {
                    $section->update([
                        'last_comment_id' => null
                    ]);
                }
            }

            $commentsTotal = Comment::query()->where('object_id', $comment->object_id)
                ->where('object', $comment->object)
                ->whereNotIn('id', [$comment->id])
                ->where('status', Comment::STATUS_APPROVED)->count('id');

            $lastComment = Comment::query()->where('object_id', $comment->object_id)
                ->where('object', $comment->object)
                ->whereNotIn('id', [$comment->id])->orderBy('id', 'desc')->first();

            $updateData = [
                'comments_cnt' => $commentsTotal
            ];

            if ($lastComment) {
                $updateData['last_comment_id'] = $lastComment->id;
                $updateData['last_comment_author'] = username($lastComment->author);
                $updateData['last_comment_at'] = $lastComment->created_at;
            }

            $object = app($comment->object)->find($comment->object_id);

            if ($object) {
                $object->update($updateData);
            }
        });
    }

    private static function field()
    {
        Field::deleting(function ($field) {
            FieldValue::whereFieldId($field->id)->delete();
        });
    }

    private static function section()
    {
        Section::deleting(function ($section) {
            $sectionSetting = SectionSetting::whereSectionId($section->id)->get()->first();
            if ($sectionSetting) {
                $sectionSetting->delete();
            }

            self::deleteImageFiles();

            LanguageObject::whereObjectId($section->id)->whereObjectType(Section::class)
                ->delete();

            ModuleSlide::whereSectionId($section->id)->delete();

            Announcement::whereObjectType(Section::class)->whereObjectId($section->id)->delete();

        });

        Section::updated(function () {
            self::deleteImageFiles();
        });
    }

    private static function articleImage()
    {
        ArticleImage::deleting(function ($articleImage) {
            self::deleteImage($articleImage->image, 'article_slider');
        });
    }

    /**
     * @throws Exception
     */
    public static function module()
    {
        $deleteFunc = function ($obModule) {
            $obModuleTemplate = Module::where('class', get_class($obModule))->first();
            if (empty($obModuleTemplate)) {
                return;
            }

            $obAnimationSettings = ModuleAnimationSettings::whereModuleId($obModule->id)
                ->whereModuleTemplateId($obModuleTemplate->id)->first();

            if (empty($obAnimationSettings)) {
                return;
            }

            $obAnimationSettings->delete();
        };

        $modules = [
            ModuleText::class, ModuleArticle::class, ModuleCatalog::class, ModuleComment::class,
            ModuleCompetitiveAdvantages::class, ModuleContacts::class, ModuleFeedback::class,
            ModuleInformation::class, ModuleMenu::class, ModuleSection::class,
            ModuleSlider::class, ModuleSocials::class, ModuleStatistics::class,
            ModuleText::class
        ];

        foreach ($modules as $module) {
            $module = app($module);
            $module::deleting($deleteFunc);
        }
    }

    public static function role()
    {
        Role::updated(function () {
            Cache::delete('guest_role');
        });
    }

    public static function user()
    {
        User::deleting(function ($user) {
            Article::query()->whereAuthorId($user->id)->delete();

            $blogSite = User::query()->find($user->id)->blogSite;

            if ($blogSite) {
                $domainVolume = $blogSite->domainVolume;

                if ($domainVolume) {
                    $domainVolume->delete();
                }

                $blogSite->delete();
            }
        });
    }

    private static function getTemplate()
    {
        return Template::getForDomain();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
