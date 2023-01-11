<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SiteUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $site_id
 * @property-read Site $site
 * @property-read User $user
 * @method static Builder|SiteUser whereId($value)
 * @method static Builder|SiteUser whereSiteId($value)
 * @method static Builder|SiteUser whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|SiteUser newModelQuery()
 * @method static Builder|SiteUser newQuery()
 * @method static Builder|SiteUser query()
 * @method static firstOrCreate(array $array)
 */
class SiteUser extends Model
{
    public $timestamps = false;
    protected $table = 'site_user';
    protected $fillable = ['user_id', 'site_id'];
    protected $connection = 'mysql';

    public function user(): BelongsTo
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class);
    }

    public function site(): BelongsTo
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Site::class);
    }

    public function roles(): SiteRole|Builder
    {
        $this->setConnection('mysql');
        return SiteRole::query()->where(['site_id' => $this->site_id, 'user_id' => $this->user_id]);
    }
}