<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Country
 *
 * @property integer $id
 * @property string $title_ru
 * @property string $title_ua
 * @property string $title_be
 * @property string $title_en
 * @property string $title_es
 * @property string $title_pt
 * @property string $title_de
 * @property string $title_fr
 * @property string $title_it
 * @property string $title_pl
 * @property string $title_ja
 * @property string $title_lt
 * @property string $title_lv
 * @property string $title_cz
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleBe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleEs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitlePt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleIt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitlePl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleLt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleLv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Country whereTitleCz($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\Country newModelQuery()
 * @method static Builder|\App\Models\Country newQuery()
 * @method static Builder|\App\Models\Country query()
 * @property string|null $title_br
 * @property string|null $title_nl
 * @property string|null $title_hr
 * @property string|null $title_fa
 * @property array|null $top_level_domain
 * @property string|null $alpha2_code
 * @property string|null $alpha3_code
 * @property string|null $capital
 * @property string|null $region
 * @property string|null $subregion
 * @property string|null $cioc
 * @property string|null $numeric_code
 * @property array|null $languages
 * @property array|null $currencies
 * @property array|null $lat_lng
 * @property array|null $calling_codes
 * @property array|null $borders
 * @property array|null $timezones
 * @method static Builder|Country whereAlpha2Code($value)
 * @method static Builder|Country whereAlpha3Code($value)
 * @method static Builder|Country whereBorders($value)
 * @method static Builder|Country whereCallingCodes($value)
 * @method static Builder|Country whereCapital($value)
 * @method static Builder|Country whereCioc($value)
 * @method static Builder|Country whereCurrencies($value)
 * @method static Builder|Country whereLanguages($value)
 * @method static Builder|Country whereLatLng($value)
 * @method static Builder|Country whereNumericCode($value)
 * @method static Builder|Country whereRegion($value)
 * @method static Builder|Country whereSubregion($value)
 * @method static Builder|Country whereTimezones($value)
 * @method static Builder|Country whereTitleBr($value)
 * @method static Builder|Country whereTitleFa($value)
 * @method static Builder|Country whereTitleHr($value)
 * @method static Builder|Country whereTitleNl($value)
 * @method static Builder|Country whereTopLevelDomain($value)
 */
class Country extends Model
{
    protected $table = 'country';
    protected $fillable = [
        'title_ru', 'title_en', 'top_level_domain', 'alpha2_code', 'alpha3_code', 'capital',
        'region', 'subregion', 'lat_lng', 'cioc', 'numeric_code', 'languages', 'currencies', 'calling_codes',
        'borders', 'timezones', 'title_fa', 'title_hr', 'title_nl', 'title_br'
    ];

    protected $casts = [
        'top_level_domain' => 'array',
        'languages' => 'array',
        'currencies' => 'array',
        'lat_lng' => 'array',
        'calling_codes' => 'array',
        'borders' => 'array',
        'timezones' => 'array'
    ];

    public $timestamps = false;
}
