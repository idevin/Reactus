<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\UserSite
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $site_id
 * @property int $logged
 * @property int|null $domain_id
 * @property int|null $admin
 * @property-read \App\Models\Domain|null $domain
 * @property-read \App\Models\Site|null $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\UserSite newModelQuery()
 * @method static Builder|\App\Models\UserSite newQuery()
 * @method static Builder|\App\Models\UserSite query()
 * @method static Builder|\App\Models\UserSite whereAdmin($value)
 * @method static Builder|\App\Models\UserSite whereDomainId($value)
 * @method static Builder|\App\Models\UserSite whereId($value)
 * @method static Builder|\App\Models\UserSite whereLogged($value)
 * @method static Builder|\App\Models\UserSite whereSiteId($value)
 * @method static Builder|\App\Models\UserSite whereUserId($value)
 * @mixin Eloquent
 */
class UserSite extends Authenticatable
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'site_id', 'logged', 'domain_id', 'admin'
    ];

    protected $table = 'user_site';
    protected $connection = 'mysqlu';

    public function getConnection(): Connection
    {
        return static::resolveConnection($this->connection);
    }

    public function site(): BelongsTo
    {
        $this->connection = 'mysql';
        return $this->belongsTo(Site::class);
    }

    public function domain(): BelongsTo
    {
        $this->connection = 'mysql';
        return $this->belongsTo(Domain::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
