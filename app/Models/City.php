<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * App\Models\City
 *
 * @property integer $id
 * @property integer $country_id
 * @property integer $region_id
 * @property boolean $important
 * @property string $title_ru
 * @property string $area_ru
 * @property string $region_ru
 * @property string $title_ua
 * @property string $area_ua
 * @property string $region_ua
 * @property string $title_be
 * @property string $area_be
 * @property string $region_be
 * @property string $title_en
 * @property string $area_en
 * @property string $region_en
 * @property string $title_es
 * @property string $area_es
 * @property string $region_es
 * @property string $title_pt
 * @property string $area_pt
 * @property string $region_pt
 * @property string $title_de
 * @property string $area_de
 * @property string $region_de
 * @property string $title_fr
 * @property string $area_fr
 * @property string $region_fr
 * @property string $title_it
 * @property string $area_it
 * @property string $region_it
 * @property string $title_pl
 * @property string $area_pl
 * @property string $region_pl
 * @property string $title_ja
 * @property string $area_ja
 * @property string $region_ja
 * @property string $title_lt
 * @property string $area_lt
 * @property string $region_lt
 * @property string $title_lv
 * @property string $area_lv
 * @property string $region_lv
 * @property string $title_cz
 * @property string $area_cz
 * @property string $region_cz
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereImportant($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleBe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaBe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionBe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleEs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaEs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionEs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitlePt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaPt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionPt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleIt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaIt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionIt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitlePl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaPl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionPl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleLt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaLt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionLt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleLv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaLv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionLv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereTitleCz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereAreaCz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereRegionCz($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\City newModelQuery()
 * @method static Builder|\App\Models\City newQuery()
 * @method static Builder|\App\Models\City query()
 * @property-read \App\Models\Country $country
 */
class City extends Model
{
    protected $table = 'city';

    public static function search(string $term, $user): Collection|array
    {
        $cities = collect();

        if (strlen($term) > 2 && $user) {
            $cities = City::query()->where('title_ru', 'like', '%' . $term . '%')
                ->orWhere('title_en', 'like', '%' . $term . '%')
                ->orWhere('title_es', 'like', '%' . $term . '%')
                ->orWhere('title_pt', 'like', '%' . $term . '%')
                ->orWhere('title_de', 'like', '%' . $term . '%')
                ->orWhere('title_fr', 'like', '%' . $term . '%')
                ->orWhere('title_it', 'like', '%' . $term . '%')
                ->orWhere('title_pl', 'like', '%' . $term . '%')
                ->orWhere('title_ja', 'like', '%' . $term . '%')
                ->orWhere('title_lv', 'like', '%' . $term . '%')
                ->orWhere('title_lt', 'like', '%' . $term . '%')
                ->orWhere('title_cz', 'like', '%' . $term . '%')
                ->orWhere('title_be', 'like', '%' . $term . '%')
                ->select(['title_ru', 'id', 'title_en'])->limit(10)->get();
        }

        return $cities;
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
