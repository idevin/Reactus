<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Traits\Activity;
use Auth;
use Cache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @activity done
     */
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Country::class);
        $this->setUserActivity();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/search/city  Поиск по городам
     * @apiGroup Search
     *
     * @apiParam {string} term строка для поиска
     *
     */
    public function city(Request $request): JsonResponse
    {
        $user = Auth::user();
        $term = $request->input('term');

        $result = City::search($term, $user);

        return $this->success(($result?->toArray()));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/search/country  Поиск по странам
     * @apiGroup Search
     *
     * @apiParam {string} term строка для поиска
     *
     */
    public function country(Request $request)
    {
        $user = Auth::user();
        $name = $request->input('term');
        $countries = null;

        if (mb_strlen($name) > 2 && $user) {
            $countries = Country::query()->where('title_ru', 'like', '%' . $name . '%')
                ->orWhere('title_ua', 'like', '%' . $name . '%')
                ->orWhere('title_en', 'like', '%' . $name . '%')
                ->orWhere('title_be', 'like', '%' . $name . '%')
                ->orWhere('title_es', 'like', '%' . $name . '%')
                ->orWhere('title_pt', 'like', '%' . $name . '%')
                ->orWhere('title_de', 'like', '%' . $name . '%')
                ->orWhere('title_fr', 'like', '%' . $name . '%')
                ->orWhere('title_it', 'like', '%' . $name . '%')
                ->orWhere('title_pl', 'like', '%' . $name . '%')
                ->orWhere('title_ja', 'like', '%' . $name . '%')
                ->orWhere('title_lv', 'like', '%' . $name . '%')
                ->orWhere('title_lt', 'like', '%' . $name . '%')
                ->orWhere('title_cz', 'like', '%' . $name . '%')
                ->select(['title_ru', 'id', 'title_en'])->limit(10)->get();
        }

        $fullCountries = [];

        if ($countries) {
            foreach ($countries as $country) {
                $foundCountry = $this->getFullCountryInfo($country);

                if ($foundCountry) {
                    $fullCountries[] = $foundCountry;
                }
            }
        }

        return $this->success($fullCountries);
    }


    public function getFullCountryInfo($country)
    {
        $countryCached = Cache::get('all_countries.' . $country->title_en);
        $countryArray = null;

        if (!$countryCached) {
            $json = file_get_contents('https://restcountries.eu/rest/v2/name/' . $country->title_en);
            $json = json_decode($json, true);

            if (count($json) > 0) {
                $country->update([
                    'top_level_odmain' => $json[0]['topLevelDomain'],
                    'alpha2_code' => $json[0]['alpha2Code'],
                    'alpha3_code' => $json[0]['alpha3Code'],
                    'capital' => $json[0]['capital'],
                    'region' => $json[0]['region'],
                    'subregion' => $json[0]['subregion'],
                    'cioc' => $json[0]['cioc'],
                    'numeric_code' => $json[0]['numericCode'],
                    'languages' => $json[0]['languages'],
                    'currencies' => $json[0]['currencies'],
                    'lat_lng' => $json[0]['latlng'],
                    'calling_codes' => $json[0]['callingCodes'],
                    'borders' => $json[0]['borders'],
                    'timezones' => $json[0]['timezones'],
                    'title_fa' => $json[0]['translations']['fa'],
                    'title_hr' => $json[0]['translations']['hr'],
                    'title_nl' => $json[0]['translations']['nl'],
                    'title_br' => $json[0]['translations']['br'],
                ]);
            }

            $countryCached = remember('all_countries.' . $country->title_en, function () use ($country) {
                return $country->toArray();
            });
        }

        return $countryCached;
    }
}