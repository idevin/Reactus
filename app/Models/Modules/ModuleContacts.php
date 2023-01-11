<?php

namespace App\Models\Modules;

use App\Contracts\Module;
use App\Models\Modules\Module as ModuleModel;
use App\Models\Site;
use App\Traits\ModuleAnimationSettings;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Modules\ModuleContacts
 *
 * @property int $id
 * @property int $module_settings_id
 * @property int $site_id
 * @property int $sort_order
 * @property string|null $template_id
 * @property string|null $name
 * @property int|null $module_id
 * @property-read mixed $animation_settings
 * @property-read \App\Models\Modules\Module|null $module
 * @property-read ModuleSettings $moduleSettings
 * @property-read Site $site
 * @method static Builder|ModuleContacts newModelQuery()
 * @method static Builder|ModuleContacts newQuery()
 * @method static Builder|ModuleContacts query()
 * @method static Builder|ModuleContacts whereId($value)
 * @method static Builder|ModuleContacts whereModuleId($value)
 * @method static Builder|ModuleContacts whereModuleSettingsId($value)
 * @method static Builder|ModuleContacts whereName($value)
 * @method static Builder|ModuleContacts whereSiteId($value)
 * @method static Builder|ModuleContacts whereSortOrder($value)
 * @method static Builder|ModuleContacts whereTemplateId($value)
 * @mixin Eloquent
 * @property array|null $phone
 * @property array|null $address
 * @method static Builder|ModuleContacts whereAddress($value)
 * @method static Builder|ModuleContacts wherePhone($value)
 */
class ModuleContacts extends ModuleBase implements Module
{
    use ModuleAnimationSettings;

    public $timestamps = false;
    public string $permissionName = 'site_contact_edit';

    protected $table = 'module_contacts';
    protected $fillable = [
        'site_id', 'sort_order', 'template_id', 'name', 'module_id', 'phone', 'address'];

    protected $hidden = ['site'];

    protected $casts = [
        'phone' => 'array',
        'address' => 'array'
    ];

    public static function getBlock(...$args): array
    {
        return [
            'phone' => $args[0]->phone,
            'address' => $args[0]->address,
            'name' => $args[0]->name
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function moduleSettings(): BelongsTo
    {
        return $this->belongsTo(ModuleSettings::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(ModuleModel::class);
    }

    static function options(...$args)
    {
        // TODO: Implement options() method.
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}