<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Models\ProfileModuleStroke
 *
 * @property int $id
 * @property int $site_id
 * @property int $user_id
 * @property string $name
 * @property string $stroke_type 1 - (1), 2 - (2+1), 3 - (2+1+1), 4 - (1+1)
 * @property int $sort_order
 * @property-read Collection|\App\Models\ProfileModuleStrokeCell[] $cells
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\ProfileModuleStroke whereId($value)
 * @method static Builder|\App\Models\ProfileModuleStroke whereName($value)
 * @method static Builder|\App\Models\ProfileModuleStroke whereSiteId($value)
 * @method static Builder|\App\Models\ProfileModuleStroke whereSortOrder($value)
 * @method static Builder|\App\Models\ProfileModuleStroke whereStrokeType($value)
 * @method static Builder|\App\Models\ProfileModuleStroke whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ProfileModuleStroke newModelQuery()
 * @method static Builder|\App\Models\ProfileModuleStroke newQuery()
 * @method static Builder|\App\Models\ProfileModuleStroke query()
 * @property-read int|null $cells_count
 */
class ProfileModuleStroke extends Model
{
    public static $strokeType = [
        1 => [
            'name' => '(1)',
            'count' => 1
        ],
        2 => [
            'name' => '(2+1)',
            'count' => 2
        ],
        3 => [
            'name' => '(2+1+1)',
            'count' => 3
        ],
        4 => [
            'name' => '(1+1)',
            'count' => 2
        ]
    ];
    public $timestamps = false;
    protected $table = 'profile_module_stroke';
    protected $fillable = [
        'user_id', 'name', 'stroke_type', 'sort_order', 'site_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cells()
    {
        return $this->hasMany(ProfileModuleStrokeCell::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}