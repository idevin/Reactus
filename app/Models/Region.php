<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Region
 *
 * @property integer $id
 * @property integer $country_id
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleUa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleBe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleEs($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitlePt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleIt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitlePl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleLt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleLv($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Region whereTitleCz($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\Region newModelQuery()
 * @method static Builder|\App\Models\Region newQuery()
 * @method static Builder|\App\Models\Region query()
 */
class Region extends Model
{
    protected $table = 'region';
}