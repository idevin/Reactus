<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\SiteRole
 *
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property int $site_id
 * @property-read \App\Models\Role $role
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\SiteRole whereId($value)
 * @method static Builder|\App\Models\SiteRole whereRoleId($value)
 * @method static Builder|\App\Models\SiteRole whereSiteId($value)
 * @method static Builder|\App\Models\SiteRole whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\SiteRole newModelQuery()
 * @method static Builder|\App\Models\SiteRole newQuery()
 * @method static Builder|\App\Models\SiteRole query()
 */
class SiteRole extends Model
{
    public $timestamps = false;
    protected $table = 'site_role';
    protected $fillable = ['role_id', 'user_id', 'site_id'];

    public function role()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Site::class);
    }
}