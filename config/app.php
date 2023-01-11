<?php

use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;
use App\Providers\ComposerServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\PermissionServiceProvider;
use App\Providers\ResponseMacroServiceProvider;
use App\Providers\RouteServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Baum\Providers\BaumServiceProvider;
use Cocur\Slugify\Bridge\Laravel\SlugifyServiceProvider;
use Collective\Html\HtmlServiceProvider;
use Conner\Tagging\Providers\TaggingServiceProvider;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Illuminate\Broadcasting\BroadcastServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;
use Illuminate\Cookie\CookieServiceProvider;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Encryption\EncryptionServiceProvider;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Foundation\Providers\ConsoleSupportServiceProvider;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Notifications\SlackChannelServiceProvider;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Pipeline\PipelineServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Session\SessionServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\View\ViewServiceProvider;
use Intervention\Image\ImageServiceProvider;
use Ixudra\Curl\CurlServiceProvider;
use Jenssegers\Date\DateServiceProvider;
use Jenssegers\Mongodb\MongodbServiceProvider;
use Propaganistas\LaravelPhone\PhoneServiceProvider;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Rutorika\Sortable\SortableServiceProvider;
use SocialiteProviders\Manager\ServiceProvider;
use Torann\GeoIP\GeoIPServiceProvider;
use Vinelab\NeoEloquent\NeoEloquentServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL'),
    'name' => env('APP_NAME'),
    'remember_time' => 1400,
    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'ru',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => env('', 'single'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        \Illuminate\Auth\AuthServiceProvider::class,
        BroadcastServiceProvider::class,
        BusServiceProvider::class,
        CacheServiceProvider::class,
        ConsoleSupportServiceProvider::class,
        CookieServiceProvider::class,
        DatabaseServiceProvider::class,
        EncryptionServiceProvider::class,
        FilesystemServiceProvider::class,
        FoundationServiceProvider::class,
        HashServiceProvider::class,
        MailServiceProvider::class,
        PaginationServiceProvider::class,
        PipelineServiceProvider::class,
        QueueServiceProvider::class,
        RedisServiceProvider::class,
        PasswordResetServiceProvider::class,
        SessionServiceProvider::class,
        TranslationServiceProvider::class,
        ValidationServiceProvider::class,
        ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        AppServiceProvider::class,
        AuthServiceProvider::class,
        EventServiceProvider::class,
        RouteServiceProvider::class,

        ComposerServiceProvider::class,
        ResponseMacroServiceProvider::class,

        HtmlServiceProvider::class,
        BladeExtensionsServiceProvider::class,
        BaumServiceProvider::class,
        PermissionServiceProvider::class,
        ImageServiceProvider::class,
        SortableServiceProvider::class,
        IdeHelperServiceProvider::class,
        ServiceProvider::class,
        DateServiceProvider::class,
        GeoIPServiceProvider::class,
        CurlServiceProvider::class,
        SlugifyServiceProvider::class,
        PhoneServiceProvider::class,
        NeoEloquentServiceProvider::class,
        SlackChannelServiceProvider::class,
        MongodbServiceProvider::class,
        TaggingServiceProvider::class,
        hisorange\BrowserDetect\ServiceProvider::class,
        Spatie\Backup\BackupServiceProvider::class,
//        CacheUserProvider::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Date' => Jenssegers\Date\Date::class,
        'ImageTool' => Intervention\Image\Facades\Image::class,
        'GeoIP' => Torann\GeoIP\Facades\GeoIP::class,
        'Curl' => Ixudra\Curl\Facades\Curl::class,
        'Slugify' => Cocur\Slugify\Bridge\Laravel\SlugifyFacade::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
    ],
    'ws' => [
        'production' => 9999,
        'development' => 8888,
        'proxy_development' => 8889,
        'proxy_production' => 9990
    ],
    'guest_allowed_routes' => [
        'api.sites.settings',
        'api.login',
        'api.logout',
        'api.credentials.login',
        'api.credentials.erase_guest_cookie',
        'personal.credentials.guest',
        'api.credentials.token',
        'api.credentials.login2',
        'api.credentials.logout',
        'credentials.guest',
        'api.credentials.check',
        'api.credentials.native_logout',
        'api.sites.check'
    ],
    'catalog_limit' => env('APP_CATALOG_LIMIT'),
    'default_middleware' => ['session', 'anon', 'activity', 'site_views', 'balance', 'browser', 'responses'],
    'activity_job' => env('APP_ACTIVITY_JOB')
];