<?php

namespace App\Models\Modules;

use App\Contracts\Module as ModuleInterface;
use App\Models\Site;
use App\Traits\ModuleAnimationSettings;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Modules\ModuleSocials
 *
 * @property int $id
 * @property int $module_settings_id
 * @property int $site_id
 * @property int $sort_order
 * @property-read mixed $animation_settings
 * @property-read mixed $facebook_url
 * @property-read mixed $instagram_url
 * @property-read mixed $ok_url
 * @property-read mixed $twitter_url
 * @property-read mixed $vk_url
 * @property-read ModuleSettings $moduleSettings
 * @property-read Site $site
 * @method static Builder|ModuleSocials newModelQuery()
 * @method static Builder|ModuleSocials newQuery()
 * @method static Builder|ModuleSocials query()
 * @method static Builder|ModuleSocials whereId($value)
 * @method static Builder|ModuleSocials whereModuleSettingsId($value)
 * @method static Builder|ModuleSocials whereSiteId($value)
 * @method static Builder|ModuleSocials whereSortOrder($value)
 * @mixin Eloquent
 * @property string|null $name
 * @method static Builder|ModuleSocials whereName($value)
 */
class ModuleSocials extends ModuleBase implements ModuleInterface
{
    use ModuleAnimationSettings;

    public $timestamps = false;
    protected $table = 'module_socials';
    protected $fillable = [
        'site_id', 'module_settings_id', 'sort_order', 'name'
    ];

    protected $appends = [
        'facebook_url', 'vk_url', 'twitter_url', 'instagram_url', 'ok_url', 'animation_settings'
    ];

    protected $hidden = ['site'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function moduleSettings()
    {
        return $this->belongsTo(ModuleSettings::class);
    }

    public function getFacebookUrlAttribute()
    {
        return $this->site->facebook_url;
    }

    public function getVkUrlAttribute()
    {
        return $this->site->vk_url;
    }

    public function getTwitterUrlAttribute()
    {
        return $this->site->twitter_url;
    }

    public function getInstagramUrlAttribute()
    {
        return $this->site->instagram_url;
    }

    public function getOkUrlAttribute()
    {
        return $this->site->ok_url;
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    public static function getBlock(...$args)
    {
        return [
            'facebook_url' => $args[0]->facebook_url,
            'vk_url' => $args[0]->vk_url,
            'twitter_url' => $args[0]->twitter_url,
            'instagram_url' => $args[0]->instagram_url,
            'ok_url' => $args[0]->ok_url,
        ];
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}