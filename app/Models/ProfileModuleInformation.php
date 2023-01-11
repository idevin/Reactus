<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProfileModuleInformation
 *
 * @property int $user_id
 * @property int $site_id
 * @property string|null $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $id
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\ProfileModuleInformation newModelQuery()
 * @method static Builder|\App\Models\ProfileModuleInformation newQuery()
 * @method static Builder|\App\Models\ProfileModuleInformation query()
 * @method static Builder|\App\Models\ProfileModuleInformation whereContent($value)
 * @method static Builder|\App\Models\ProfileModuleInformation whereCreatedAt($value)
 * @method static Builder|\App\Models\ProfileModuleInformation whereId($value)
 * @method static Builder|\App\Models\ProfileModuleInformation whereSiteId($value)
 * @method static Builder|\App\Models\ProfileModuleInformation whereUpdatedAt($value)
 * @method static Builder|\App\Models\ProfileModuleInformation whereUserId($value)
 * @mixin Eloquent
 */
class ProfileModuleInformation extends Model
{
    public $timestamps = true;
    protected $table = 'profile_module_information';
    protected $fillable = [
        'user_id', 'site_id', 'content'
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
