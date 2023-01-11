<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ProfileModuleActivity
 *
 * @property int $id
 * @property int $user_id
 * @property int $site_id
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\ProfileModuleActivity whereId($value)
 * @method static Builder|\App\Models\ProfileModuleActivity whereSiteId($value)
 * @method static Builder|\App\Models\ProfileModuleActivity whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ProfileModuleActivity newModelQuery()
 * @method static Builder|\App\Models\ProfileModuleActivity newQuery()
 * @method static Builder|\App\Models\ProfileModuleActivity query()
 */
class ProfileModuleActivity extends Model
{
    public $timestamps = false;
    protected $table = 'profile_module_activity';
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
