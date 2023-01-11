<?php

namespace App\Providers;

use App\Models\BlogSite;
use App\Models\Community;
use App\Models\Site;
use App\Models\Template;
use Illuminate\Support\ServiceProvider;
use Session;

class ComposerServiceProvider extends ServiceProvider
{
    public static $site = null;
    public static $favicon = null;
    public static $personalSite = null;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (php_sapi_name() !== 'cli') {
            if (!self::$site) {
                $site = Site::whereDomain(env('DOMAIN'))->first();

                if ($site) {
                    self::$site = $site;
                }

                if ($site && !self::$favicon) {
                    self::$favicon = $site->faviconUrlV2();
                }
            }

            view()->share('ajaxBaseUrl', ajax_base_url());
            view()->share('settings', settings());
            view()->share('favicon', self::$favicon);
            view()->share('site', self::$site);

            view()->share('geo', geo());

            if (!Session::get('templates')) {
                $templates = Template::all()->pluck('alias')->toArray();
                Session::put('templates', $templates);
            }

            $templates = Session::get('templates');

            view()->composer($templates, function ($view) {
                $view->with('permissions', permissions(auth()->user()));
            });

            view()->composer(['ProfileLayout'], function ($view) {
                $view->with('permissions', permissions(null, true, null, BlogSite::class));
            });

            if (self::$site && !self::$site->template) {
                self::$site = self::$site->setTemplate();
            }

            if (!self::$site) {
                $theme = 'ProfileLayout';
            } else {
                $theme = self::$site->template->alias;
            }

            if (!empty($theme)) {
                $manifest = file_get_contents(__DIR__ . DS . '..' . DS . '..' . DS .
                    'resources' . DS . 'stub-public' . DS . 'node-core' . DS . 'manifest.json');

                if (!empty($manifest)) {
                    $jsonManifest = json_decode($manifest, true);
                    view()->share('assets', $jsonManifest[$theme] ?? null);
                }
            } else {
                $theme = 'MinimalLayout';
            }

            view()->share('theme', $theme);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
