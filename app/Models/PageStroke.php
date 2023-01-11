<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\PageStroke
 *
 * @property int $id
 * @property int $page_id
 * @property int $module_stroke_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $sort_order
 * @property int $position
 * @property int $is_active
 * @property Carbon|null $deleted_at
 * @property string|null $template_id
 * @property array|null $content_options
 * @property-read Collection|\App\Models\PageStrokeModule[] $modules
 * @property-read int|null $modules_count
 * @property-read \App\Models\Page $page
 * @property-read Collection|\App\Models\PageStrokeModuleRevision[] $revisionModules
 * @property-read int|null $revision_modules_count
 * @method static Builder|PageStroke newModelQuery()
 * @method static Builder|PageStroke newQuery()
 * @method static Builder|PageStroke query()
 * @method static Builder|PageStroke whereContentOptions($value)
 * @method static Builder|PageStroke whereCreatedAt($value)
 * @method static Builder|PageStroke whereDeletedAt($value)
 * @method static Builder|PageStroke whereId($value)
 * @method static Builder|PageStroke whereIsActive($value)
 * @method static Builder|PageStroke whereModuleStrokeId($value)
 * @method static Builder|PageStroke wherePageId($value)
 * @method static Builder|PageStroke wherePosition($value)
 * @method static Builder|PageStroke whereSortOrder($value)
 * @method static Builder|PageStroke whereTemplateId($value)
 * @method static Builder|PageStroke whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageStroke extends PageStrokeRevision
{
    protected $table = 'page_stroke';

    const POSITION_HEADER = 1;
    const POSITION_FOOTER = 2;
    const POSITION_CONTENT = 3;

    public static array $positions = [
        self::POSITION_HEADER => 'header',
        self::POSITION_FOOTER => 'footer',
        self::POSITION_CONTENT => 'content'
    ];

    protected $relations = [
        'modules' => PageStrokeModule::class
    ];

    public function modules(): HasMany
    {
        return $this->hasMany(PageStrokeModule::class)->orderBy('sort_order');
    }
}
