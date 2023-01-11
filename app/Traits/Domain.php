<?php

namespace App\Traits;

use App;
use App\Helpers\Deployer\Classes\Deployer;
use App\Models\Domain as DomainModel;
use App\Models\DomainThematic;
use App\Models\DomainVolume;
use App\Models\Language;
use App\Models\Site;
use App\Models\Template;
use DB;
use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Validator as IlluminateValidator;
use Validator;

trait Domain
{
    public static function createSiteDomainValidator($data, $except = [],
                                                     $customErrors = [], $customMessages = []): IlluminateValidator
    {

        $dnsCheck = env('DOMAIN') != env('LOCAL_DOMAIN') ? '|domain_valid_dns' : '';

        $default = [
            'name' => 'required|domain_valid' . $dnsCheck
        ];

        $messages = [
            'name.domain_valid_dns' => 'NS сервера не найдены',
            'name.domain_valid' => 'Домен невалидный',
            'name.required' => 'Не задано имя домена'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function getRandomPersonal()
    {
        $personalDomain = DomainModel::whereDomainType(DomainModel::DOMAIN_TYPE_PERSONAL);

        $personalDomain = $personalDomain
            ->whereNotIn('name', [config('netgamer.local_content_domain')]);

        $personalDomain = $personalDomain->get();

        if (count($personalDomain) > 0) {
            return $personalDomain->random();
        }
        return null;
    }

    public static function cCookie($domain, $data): \Symfony\Component\HttpFoundation\Cookie
    {
        $data = encrypt($data, false);
        $secure = self::secureCookie();

        return Cookie::make('c', $data, 2628000, '/', '.' . $domain, $secure[0], true, false, $secure[1]);
    }

    public static function secureCookie(): array
    {
        if (config('session.secure') == true) {
            $secure = true;
            $sameSite = 'None';
        } else {
            $secure = false;
            $sameSite = null;
        }

        return [$secure, $sameSite];
    }

    /**
     * @param $domain
     * @param $data
     * @return mixed
     */
    public static function gCookie($domain, $data)
    {
        $data = encrypt($data, false);
        $secure = self::secureCookie();

        return Cookie::make('g', $data, 2628000, '/', '.' . $domain, $secure[0], true, false, $secure[1]);
    }

    /**
     * @throws Exception
     */
    public function setDefaultDomain()
    {
        /**
         * TODO Метод используется? вроде нет. Тогда зачем он нужен?
         */

        DB::unprepared("ALTER TABLE `domain` AUTO_INCREMENT = 1;");
        DB::unprepared("ALTER TABLE `site` AUTO_INCREMENT = 1;");

        $domainExists = DomainModel::whereName(env('DEFAULT_DOMAIN'));
        $environmentName = env('ENV');

        if (env('DEVELOPMENT') == true) {
            $domainExists = $domainExists->whereEnvironment(0);
            $environment = 0;
        } else {
            $domainExists = $domainExists->whereEnvironment(1);
            $environment = 1;
        }

        $domainExists = $domainExists->first();

        if (!$domainExists) {
            $domainThematic = DomainThematic::query()->inRandomOrder()->first();

            $language = Language::query()->whereAlias(App::getLocale())->first();

            if (!$language) {
                $language = Language::query()->whereAlias(config('app.locale'))->first();
            }

            $pvc = DomainVolume::createPvc();

            $data = [
                'name' => env('DEFAULT_DOMAIN'),
                'is_default' => 1,
                'domain_type' => DomainModel::DOMAIN_TYPE_THEMATIC,
                'environment' => $environment,
                'domain_thematic_id' => $domainThematic->id,
                'language_id' => $language->id,
                'domain_volume_id' => $pvc->id
            ];

            $domain = DomainModel::create($data);
            $template = Template::where('default', 1)->first();

            $siteRoot = Site::create([
                'title' => env('DEFAULT_DOMAIN'),
                'domain' => env('DEFAULT_DOMAIN'),
                'domain_id' => $domain->id,
                'template_id' => $template->id,
                'archive' => 1
            ]);

            $siteRoot->makeRoot();

            $sites = Site::where('archive', 1)->get();

            if (count($sites) > 0) {
                foreach ($sites as $site) {
                    $site->makeChildOf($siteRoot);
                }
            }

            (new Deployer(env('DEFAULT_DOMAIN'), $domain->domainVolume))->v1();
        }
    }

    public function deleteDomain($domain)
    {
        if ($domain) {

            Deployer::uninstall($domain->name);

            /**
             * TODO передача данных в родительский домен сделана криво. Надо обсуждать
             */
            if ($domain->parent && $domain->parent->user_id != null && $domain->user_id != null) {

                (new Deployer($domain->parent->name, $domain->domainVolume))->v1();
            }

            forget(Site::class . '.' . $domain->name);
            forget('settings.' . $domain->name);
        }
    }
}
