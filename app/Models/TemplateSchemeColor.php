<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\TemplateSchemeColor
 *
 * @property int $template_scheme_id
 * @property string $color
 * @property-read \App\Models\TemplateScheme $templateScheme
 * @method static Builder|\App\Models\TemplateSchemeColor newModelQuery()
 * @method static Builder|\App\Models\TemplateSchemeColor newQuery()
 * @method static Builder|\App\Models\TemplateSchemeColor query()
 * @method static Builder|\App\Models\TemplateSchemeColor whereColor($value)
 * @method static Builder|\App\Models\TemplateSchemeColor whereTemplateSchemeId($value)
 * @mixin Eloquent
 */
class TemplateSchemeColor extends Model
{
    public $timestamps = false;
    protected $table = 'template_scheme_color';
    protected $fillable = ['color', 'template_scheme_id'];
}