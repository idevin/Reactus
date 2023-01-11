<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ProfileModuleBlog
 *
 * @property int $user_id
 * @property int $site_id
 * @property string $content
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\ProfileModuleBlog whereContent($value)
 * @method static Builder|\App\Models\ProfileModuleBlog whereSiteId($value)
 * @method static Builder|\App\Models\ProfileModuleBlog whereUserId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ProfileModuleBlog newModelQuery()
 * @method static Builder|\App\Models\ProfileModuleBlog newQuery()
 * @method static Builder|\App\Models\ProfileModuleBlog query()
 */
class ProfileModuleBlog extends Model
{
    public $timestamps = true;
    protected $table = 'profile_module_blog';
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