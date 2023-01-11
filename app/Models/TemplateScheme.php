<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * App\Models\TemplateScheme
 *
 * @property int $id
 * @property string|null $name
 * @property int $default
 * @property int $default_global
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Models\TemplateSchemeColor[] $colors
 * @property-read Collection|\App\Models\Template[] $templates
 * @method static Builder|\App\Models\TemplateScheme default()
 * @method static Builder|\App\Models\TemplateScheme defaultSchemes()
 * @method static Builder|\App\Models\TemplateScheme newModelQuery()
 * @method static Builder|\App\Models\TemplateScheme newQuery()
 * @method static Builder|\App\Models\TemplateScheme query()
 * @method static Builder|\App\Models\TemplateScheme whereCreatedAt($value)
 * @method static Builder|\App\Models\TemplateScheme whereDefault($value)
 * @method static Builder|\App\Models\TemplateScheme whereDefaultGlobal($value)
 * @method static Builder|\App\Models\TemplateScheme whereId($value)
 * @method static Builder|\App\Models\TemplateScheme whereName($value)
 * @method static Builder|\App\Models\TemplateScheme whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $colors_count
 * @property-read int|null $templates_count
 * @property int $is_user_defined
 * @method static Builder|\App\Models\TemplateScheme whereColors($value)
 * @method static Builder|\App\Models\TemplateScheme whereIsUserDefined($value)
 */
class TemplateScheme extends Model
{
    public $timestamps = true;
    protected $table = 'template_scheme';

    protected $fillable = [
        'name', 'default', 'default_global', 'is_user_defined', 'colors'
    ];

    protected $casts = [
        'colors' => 'array'
    ];

    public function scopeDefaultSchemes($query)
    {
        return $query->where(['default' => 1]);
    }

    public function scopeDefault($query)
    {
        return $query->where('default_global', 1);
    }

    public function templates()
    {
        return $this->belongsToMany(Template::class, 'template_to_template_scheme');
    }
}