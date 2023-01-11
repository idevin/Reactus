<?php


namespace App\Traits;


use Ixudra\Curl\CurlService;

trait Selectel
{

    public static function addNsRecords($domain): bool
    {
        $url = 'https://api.selectel.ru/domains/v1/';
        $key = env('SELECTEL_API_KEY', 'Jk2G4Q411wa7CXSL7QM4WbnvH_61500');

        $soa = "$domain. 300 IN SOA ns1.selectel.org. support.selectel.ru. 2018123101 10800 3600 604800 300\n
        $domain. 86400 IN NS ns1.selectel.org.\n
        $domain. 86400 IN NS ns2.selectel.org.\n
        $domain. 86400 IN NS ns3.selectel.org.\n
        $domain. 86400 IN NS ns4.selectel.org.\n
        $domain. 86400 IN MX 10 mail.$domain.\n
        localhost.$domain. 86400 IN A 127.0.0.1\n
        mail.$domain. 86400 IN A 127.0.0.25\n";

        $response = (new CurlService())->to($url)->withData(['name' => $domain, 'bind_zone' => $soa])
            ->withHeaders(['X-Token:' . $key, "Content-Type: application/json"])
            ->returnResponseObject()->allowRedirect()->post();

        if(env('APP_DEBUG_VARS') == true) {
            debugvars('SELECTEL NS', [$response->content]);
        }

        if ($response->status !== 200) {
            return false;
        }

        return true;
    }

}