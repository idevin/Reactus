<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\PageStrokeRevision
 *
 * @property int $id
 * @property int $page_id
 * @property int $sort_order
 * @property int $is_active
 * @property int|null $is_current
 * @property int $position
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $template_id
 * @property array|null $content_options
 * @property-read \App\Models\Page $page
 * @property-read Collection|\App\Models\PageStrokeModuleRevision[] $revisionModules
 * @property-read int|null $revision_modules_count
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision newQuery()
 * @method static Builder|PageStrokeRevision onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereContentOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereIsCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageStrokeRevision whereUpdatedAt($value)
 * @method static Builder|PageStrokeRevision withTrashed()
 * @method static Builder|PageStrokeRevision withoutTrashed()
 * @mixin \Eloquent
 */
class PageStrokeRevision extends Model
{
    use Rememberable;
    use SoftDeletes;

    public string $rememberCacheTag = self::class;
    public $timestamps = true;

    protected $table = 'page_stroke_revision';

    /**
     * @var array
     * @fillable  'page_id', 'position', 'sort_order', 'created_at', 'updated_at', 'active', 'template_id
     * 'is_current', 'deleted_at', 'content_options'
     */
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    protected $connection = 'mysql';

    protected $casts = [
        'content_options' => 'array'
    ];

    const POSITION_HEAD = 1;
    const POSITION_CONTENT = 2;
    const POSITION_FOOT = 3;

    public static array $positions = [
        self::POSITION_HEAD => 'Шапка',
        self::POSITION_FOOT => 'Подвал',
        self::POSITION_CONTENT => 'Контент'
    ];

    const ACTIVE = 1;
    const INACTIVE = 0;

    public static array $activeFlags = [
        self::ACTIVE, self::INACTIVE
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function revisionModules(): HasMany
    {
        return $this->hasMany(PageStrokeModuleRevision::class, 'page_stroke_id')->orderBy('sort_order', 'asc');
    }

    /**
     * @param $page
     * @return string|PageStroke|PageStrokeRevision
     */
    public static function model($page): string|PageStroke|PageStrokeRevision
    {
        $model = PageStroke::class;

        if ((int)$page->is_edit_mode == 1) {
            $model = PageStrokeRevision::class;
        }

        return app($model);
    }

    protected static function boot()
    {
        parent::boot();
        PageStrokeRevision::creating(function ($pageRev) {
            PageStrokeRevision::setCurrent($pageRev);
        });

        PageStrokeRevision::updating(function ($pageRev) {
            PageStrokeRevision::setCurrent($pageRev);
        });
    }

    public static function setCurrent($pageRev)
    {
        PageStrokeRevision::query()->whereIsCurrent(1)->update([
            'is_current' => 0
        ]);

        $pageRev->is_current = 1;
    }
}
