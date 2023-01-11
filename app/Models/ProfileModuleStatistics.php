<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ProfileModuleStatistics
 *
 * @property int $id
 * @property int $user_id
 * @property int $site_id
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\ProfileModuleStatistics whereId($value)
 * @method static Builder|\App\Models\ProfileModuleStatistics whereSiteId($value)
 * @method static Builder|\App\Models\ProfileModuleStatistics whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ProfileModuleStatistics newModelQuery()
 * @method static Builder|\App\Models\ProfileModuleStatistics newQuery()
 * @method static Builder|\App\Models\ProfileModuleStatistics query()
 */
class ProfileModuleStatistics extends Model
{
    public $timestamps = false;
    protected $table = 'profile_module_statistics';
    protected $fillable = [
        'user_id', 'site_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
