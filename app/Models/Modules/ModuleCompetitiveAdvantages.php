<?php namespace App\Models\Modules;

use App\Contracts\Module;
use App\Models\FieldGroup;
use App\Models\Modules\Module as ModuleModel;
use App\Models\Site as SiteModel;
use App\Models\StorageFile;
use App\Traits\Feedback;
use App\Traits\ModuleAnimationSettings;
use App\Traits\Site;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class ModuleCompetitiveAdvantages
 *
 * @property int $id
 * @property int $site_id
 * @property int $module_settings_id
 * @property int $module_id
 * @property int $sort_order
 * @property string $items
 * @property string $name
 * @property array $view_template
 * @property int $orient
 * @property Site $site
 * @property Module $module
 * @package App\Models\Modules
 * @method static self whereID(int $id)
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $item_image_options
 * @property-read mixed $animation_settings
 * @property-read mixed $item_options
 * @method static Builder|ModuleCompetitiveAdvantages newModelQuery()
 * @method static Builder|ModuleCompetitiveAdvantages newQuery()
 * @method static Builder|ModuleCompetitiveAdvantages query()
 * @method static Builder|ModuleCompetitiveAdvantages whereCreatedAt($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereItemImageOptions($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereItems($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereModuleId($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereModuleSettingsId($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereName($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereOrient($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereSiteId($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereSortOrder($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereTitlePosition($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereUpdatedAt($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereViewTemplate($value)
 * @mixin Eloquent
 * @property string|null $template_id
 * @property array|null $content_options
 * @method static Builder|ModuleCompetitiveAdvantages whereContentOptions($value)
 * @method static Builder|ModuleCompetitiveAdvantages whereTemplateId($value)
 * @property int $full_screen
 * @method static Builder|ModuleCompetitiveAdvantages whereFullScreen($value)
 * @property-read int|null $items_count
 * @property array|null $settings
 * @method static Builder|ModuleCompetitiveAdvantages whereSettings($value)
 */
class ModuleCompetitiveAdvantages extends ModuleBase implements Module
{
    use Site;
    use ModuleAnimationSettings;

    public string $permissionName = 'competitive_advantages_edit';

    public $timestamps = false;

    const CIRCLE_PHOTO_TEMPLATE_ID = 0;
    const SQUARE_PHOTO_TEMPLATE_ID = 1;
    const LIST_TEMPLATE = 2;

    const DEFAULT_BUTTON_OBJ = [
        'show' => false,
        'redirect_url' => '',
        'title' => '',
    ];

    const DEFAULT_OPTIONS = [
        [
            'input' => 'image',
            'type' => 'image',
            'sort_order' => 0,
        ],
        [
            'input' => 'title',
            'type' => 'text',
            'sort_order' => 1,
        ],
        [
            'input' => 'text',
            'type' => 'textarea',
            'sort_order' => 2,
        ],
        [
            'input' => 'button',
            'type' => 'button',
            'template' => self::DEFAULT_BUTTON_OBJ,
            'sort_order' => 3,
        ],
    ];

    const VIEW_TEMPLATE_LIST = [
        [
            "id" => self::CIRCLE_PHOTO_TEMPLATE_ID,
            "description" => "Шаблон круглые фото",
            'type' => 'circle',
            'options' => [
                self::DEFAULT_OPTIONS,
            ],
        ],
        [
            "id" => self::SQUARE_PHOTO_TEMPLATE_ID,
            "description" => "Шаблон квадратные фото",
            'type' => 'square',
            'options' => [
                self::DEFAULT_OPTIONS,
            ],
        ],
        [
            "id" => self::LIST_TEMPLATE,
            "description" => "Список",
            'type' => 'list',
            'options' => [
                'item_settings' => self::ITEM_TEMPLATE_LIST,
                self::DEFAULT_OPTIONS,
            ],
        ],
        [
            "id" => 4,
            "description" => "круглые картинки",
            'type' => 'circle_under_text',
            'options' => [
                self::DEFAULT_OPTIONS,
            ],
        ],
        [
            "id" => 5,
            "description" => "квадратные картинки",
            'type' => 'square_under_text',
            'options' => [
                self::DEFAULT_OPTIONS,
            ],
        ],
        [
            "id" => 7,
            "description" => "квадратные картинки, полный",
            'type' => 'square_full_under_text',
            'options' => [
                self::DEFAULT_OPTIONS,
            ],
        ],
        [
            "id" => 8,
            "description" => "списком",
            'type' => 'icon_list_text',
            'options' => [
                'item_settings' => self::ITEM_TEMPLATE_LIST,
                self::DEFAULT_OPTIONS,
            ],
        ],
    ];

    const TITLE_LEFT = 0;
    const TITLE_RIGHT = 1;
    const TITLE_OPTIONS = [
        self::TITLE_LEFT => 'Слева',
        self::TITLE_RIGHT => 'Справа',
    ];

    const ORIENT_LEFT = 0;
    const ORIENT_RIGHT = 1;
    const ORIENT_OPTIONS = [
        self::ORIENT_LEFT => 'Вертикальный',
        self::ORIENT_RIGHT => 'Горизонтальный',
    ];

    const COLUMNS_OPTIONS = [
        1, 2, 3, 4,
    ];

    const ITEM_IMAGE_SQUARE = 0;
    const ITEM_IMAGE_CIRCLE = 1;
    const ITEM_IMAGE_DOT = 2;
    const ITEM_IMAGE_FRAME_OPTIONS = [
        self::ITEM_IMAGE_CIRCLE => 'Круглая',
        self::ITEM_IMAGE_SQUARE => 'Квадратная',
        self::ITEM_IMAGE_DOT => 'Точка',
    ];

    const ITEM_TEMPLATE_FILE = 0;
    const ITEM_TEMPLATE_DOT = 1;

    const ITEM_TEMPLATE_LIST = [
        [
            "id" => self::ITEM_TEMPLATE_FILE,
            "description" => "Изображение",
            'type' => 'image',
        ],
        [
            "id" => self::ITEM_TEMPLATE_DOT,
            "description" => "Точка",
            'type' => 'dot',
        ],
    ];

    public $table = "module_competitive_advantages";
    public $fillable = [
        "site_id",
        "module_settings_id",
        "module_id",
        "name",
        'template_id',
        'content_options',
        'full_screen',
        'settings'
    ];

    protected $appends = [
        'animation_settings',
        'items'
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    public $timestamps = false;

    public static function getBlock(...$args)
    {
        return $args[0];
    }

    public function site()
    {
        return $this->belongsTo(SiteModel::class);
    }

    public function moduleSettings()
    {
        return $this->belongsTo(ModuleSettings::class)->first();
    }

    public function module()
    {
        return $this->belongsTo(ModuleModel::class)->first();
    }

    public function image()
    {
        if (empty($this->attributes['image_id'])) {
            return null;
        }

        return $this->hasOne(StorageFile::class, 'id', 'image_id');
    }

    public function setViewTemplateAttribute($arViewTemplate)
    {
        if (empty($arViewTemplate)) {
            $this->attributes['view_template'] = '';
            return;
        }

        $this->attributes['view_template'] = json_encode($arViewTemplate);
    }

    public function getViewTemplateAttribute()
    {
        if ($this->attributes['view_template'] == '') {
            return [];
        }

        return json_decode($this->attributes['view_template'], true);
    }

    public function getItemsAttribute(): Collection
    {
        return $this->items()->get();
    }

    public function items(): HasMany
    {
        return $this->hasMany(ModuleCompetitiveAdvantagesItems::class, 'advantages_id')
            ->orderBy('sort_order');
    }

    #[ArrayShape(['feedback' => "array"])]
    static function options(...$args): array
    {
        $nodes = FieldGroup::roots()->get();
        return [
            'feedback' => Feedback::tree(nodes: $nodes)
        ];
    }

    static function id(...$args)
    {
        // TODO: Implement id() method.
    }
}