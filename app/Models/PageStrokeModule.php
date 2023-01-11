<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\PageStrokeModule
 *
 * @property int $id
 * @property int $page_stroke_id
 * @property string $module_class
 * @property int|null $module_id
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $is_active
 * @property Carbon|null $deleted_at
 * @property string|null $template_id
 * @property array|null $content_options
 * @property-read mixed $data
 * @property-read mixed $module_object
 * @property-read \App\Models\PageStroke $stroke
 * @method static Builder|PageStrokeModule newModelQuery()
 * @method static Builder|PageStrokeModule newQuery()
 * @method static Builder|PageStrokeModule query()
 * @method static Builder|PageStrokeModule whereContentOptions($value)
 * @method static Builder|PageStrokeModule whereCreatedAt($value)
 * @method static Builder|PageStrokeModule whereDeletedAt($value)
 * @method static Builder|PageStrokeModule whereId($value)
 * @method static Builder|PageStrokeModule whereIsActive($value)
 * @method static Builder|PageStrokeModule whereModuleClass($value)
 * @method static Builder|PageStrokeModule whereModuleId($value)
 * @method static Builder|PageStrokeModule wherePageStrokeId($value)
 * @method static Builder|PageStrokeModule whereSortOrder($value)
 * @method static Builder|PageStrokeModule whereTemplateId($value)
 * @method static Builder|PageStrokeModule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PageStrokeModule extends PageStrokeModuleRevision
{
    protected $table = 'page_stroke_module';

    public function stroke(): BelongsTo
    {
        return $this->belongsTo(PageStroke::class);
    }
}
