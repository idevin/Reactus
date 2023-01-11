<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\NativeCity
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereImportant($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleBe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaBe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionBe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleEs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaEs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionEs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitlePt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaPt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionPt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleIt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaIt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionIt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitlePl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaPl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionPl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleLt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaLt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionLt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleLv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaLv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionLv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereTitleCz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereAreaCz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\NativeCity whereRegionCz($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\NativeCity newModelQuery()
 * @method static Builder|\App\Models\NativeCity newQuery()
 * @method static Builder|\App\Models\NativeCity query()
 */
class NativeCity extends Model
{
    protected $table = 'city';
}
