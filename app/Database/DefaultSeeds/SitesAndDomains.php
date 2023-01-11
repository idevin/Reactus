<?php

namespace App\Database\DefaultSeeds;

use App;
use App\Models\Domain;
use App\Models\DomainVolume;
use App\Models\Language;
use App\Models\Site;
use App\Models\Template;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SitesAndDomains extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        Model::unguard();

        $data = [
            env('AUTH_DOMAIN') => Domain::DOMAIN_TYPE_THEMATIC,
            env('LOCAL_DOMAIN') => Domain::DOMAIN_TYPE_THEMATIC,
            env('DEFAULT_DOMAIN') => Domain::DOMAIN_TYPE_THEMATIC,
            env('DEFAULT_PERSONAL_DOMAIN') => Domain::DOMAIN_TYPE_PERSONAL
        ];

        foreach ($data as $domainName => $type) {
            self::installDomains($domainName, $type);
        }
    }

    /**
     * @param string $domainName
     * @param string $type
     * @throws Exception
     */
    public static function installDomains(string $domainName, string $type)
    {
        $site = Site::query()->withTrashed()->whereDomain($domainName)->first();
        $title = preg_split('#\.#', $domainName);
        $template = Template::query()->whereAlias('MinimalLayout')->first();
        $domain = Domain::query()->whereName($domainName)->first();

        $language = Language::query()->whereAlias(App::getLocale())->first();

        if (!$language) {
            $language = Language::query()->whereAlias(config('app.locale'))->first();
        }

        $domainData = [
            'name' => $domainName,
            'domain_type' => $type,
            'environment' => env('DEVELOPMENT') == true ? 0 : 1,
            'ssl' => 1,
            'is_default' => 1,
            'language_id' => $language->id
        ];

        if (!$domain) {
            $pvc = DomainVolume::createPvc();
            $domainData['domain_volume_id'] = $pvc->id;
            $domain = Domain::query()->firstOrCreate(['name' => $domainName], $domainData);
        } else {
            $domain->update($domainData);
            $domain->refresh();
        }

        $siteData = [
            'domain' => $domainName,
            'title' => ucfirst($title[0]),
            'rating' => 0,
            'template_id' => $template->id,
            'domain_id' => $domain->id
        ];

        if (!$site) {
            Site::query()->firstOrCreate(['domain' => $domainName], $siteData);
        } else {
            $site->update($siteData);
        }
    }
}