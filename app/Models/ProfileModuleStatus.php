<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ProfileModuleStatus
 *
 * @property int $user_id
 * @property int $site_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\ProfileModuleStatus whereCreatedAt($value)
 * @method static Builder|\App\Models\ProfileModuleStatus whereSiteId($value)
 * @method static Builder|\App\Models\ProfileModuleStatus whereUpdatedAt($value)
 * @method static Builder|\App\Models\ProfileModuleStatus whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ProfileModuleStatus newModelQuery()
 * @method static Builder|\App\Models\ProfileModuleStatus newQuery()
 * @method static Builder|\App\Models\ProfileModuleStatus query()
 */
class ProfileModuleStatus extends Model
{
    public $timestamps = true;
    protected $table = 'profile_module_status';
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
