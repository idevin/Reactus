<?php

namespace App\Models;

use App\Models\Modules\ModuleMenuAdvancedUrl;

/**
 * App\Models\Anchor
 *
 * @property int $id
 * @property int $anchor_id
 * @property int $anchor_type
 * @property string|null $name
 * @property string|null $alias
 * @property-read ModuleMenuAdvancedUrl $url
 * @method static \Illuminate\Database\Eloquent\Builder|Anchor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anchor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anchor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Anchor whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anchor whereAnchorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anchor whereAnchorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anchor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anchor whereName($value)
 * @mixin \Eloquent
 */
class Anchor extends Model
{
    public $timestamps = false;
    protected $table = 'anchor';
    protected $fillable = ['id', 'anchor_type', 'anchor_id', 'name', 'alias'];

    public function url()
    {
        return $this->belongsTo(ModuleMenuAdvancedUrl::class);
    }
}
