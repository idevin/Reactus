<?php

namespace App\Models\Modules;

use App\Contracts\Module;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\Modules\Module as ModuleModel;
use App\Models\Modules\Site as SiteModel;
use App\Traits\Feedback;
use App\Traits\ModuleAnimationSettings;
use App\Traits\Site;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\Modules\ModuleFeedback
 *
 * @property int $id
 * @property int $site_id
 * @property int $module_settings_id
 * @property int $sort_order
 * @property string|null $name
 * @property int $field_group_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $registration
 * @property int $modal
 * @property int $module_id
 * @property-read \App\Models\Modules\FieldGroup $fieldGroup
 * @property-read mixed $animation_settings
 * @property-read mixed $fields
 * @property-read \App\Models\Modules\Module $moduleSettings
 * @property-read \App\Models\Site $site
 * @method static Builder|ModuleFeedback newModelQuery()
 * @method static Builder|ModuleFeedback newQuery()
 * @method static Builder|ModuleFeedback query()
 * @method static Builder|ModuleFeedback whereCreatedAt($value)
 * @method static Builder|ModuleFeedback whereFieldGroupId($value)
 * @method static Builder|ModuleFeedback whereId($value)
 * @method static Builder|ModuleFeedback whereModal($value)
 * @method static Builder|ModuleFeedback whereModuleId($value)
 * @method static Builder|ModuleFeedback whereModuleSettingsId($value)
 * @method static Builder|ModuleFeedback whereName($value)
 * @method static Builder|ModuleFeedback whereRegistration($value)
 * @method static Builder|ModuleFeedback whereSiteId($value)
 * @method static Builder|ModuleFeedback whereSortOrder($value)
 * @method static Builder|ModuleFeedback whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ModuleFeedback extends ModuleBase implements Module
{
    use Site;
    use ModuleAnimationSettings;
    use Feedback;

    const SORT_ORDER_ASC = 1;
    const SORT_ORDER_DESC = 2;
    public static $sortOrder = [
        [
            'id' => self::SORT_ORDER_ASC,
            'alias' => 'ASC',
            'name' => 'По возрастанию'
        ],
        [
            'id' => self::SORT_ORDER_DESC,
            'alias' => 'DESC',
            'name' => 'По убыванию'
        ]
    ];
    protected $table = 'module_feedback';

    protected $fillable = [
        'site_id', 'module_settings_id', 'sort_order', 'name', 'field_group_id',
        'registration', 'modal', 'module_id'
    ];
    protected $appends = [
        'fields',
        'animation_settings',
    ];

    public $timestamps = false;

    public static function getBlock(...$args)
    {
        return $args[0];
    }

    public function getFieldsAttribute()
    {
        $fields = [];
        if ($this->fieldGroup) {
            $this->makeHidden(['fieldGroup']);
            $fields = self::mapFields($this->fieldGroup->fields);
        }

        return $fields;
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(SiteModel::class);
    }

    public function fieldGroup(): BelongsTo
    {
        return $this->belongsTo(FieldGroup::class);
    }

    public function moduleSettings(): BelongsTo
    {
        return $this->belongsTo(ModuleModel::class);
    }

    #[ArrayShape(['module_feedback_select' => "array|string[]"])]
    static function options(...$args)
    {
        $nodes = FieldGroup::query()->where('for_module', 1)->get();

        return [
            'module_feedback_select' => self::tree(nodes: $nodes, withRoot: true, withEmptyValue: $nodes)
        ];
    }

    static function id(...$args)
    {
        return null;
    }
}