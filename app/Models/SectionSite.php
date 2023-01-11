<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SectionSite
 *
 * @property int $id
 * @property int $site_id
 * @property int $from_site_id
 * @property int $section_id
 * @property int|null $to_section_id
 * @property int $announce
 * @property string|null $deleted_at
 * @property int $moderated
 * @property-read Site $fromSite
 * @property-read Section $section
 * @property-read Site $site
 * @property-read Template $template
 * @property-read Section|null $toSection
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|SectionSite onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|SectionSite sections($siteId)
 * @method static Builder|SectionSite whereDeletedAt($value)
 * @method static Builder|SectionSite whereFromSiteId($value)
 * @method static Builder|SectionSite whereId($value)
 * @method static Builder|SectionSite whereModerated($value)
 * @method static Builder|SectionSite whereSectionId($value)
 * @method static Builder|SectionSite whereSiteId($value)
 * @method static Builder|SectionSite whereToSectionId($value)
 * @method static \Illuminate\Database\Query\Builder|SectionSite withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SectionSite withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|SectionSite newModelQuery()
 * @method static Builder|SectionSite newQuery()
 * @method static Builder|SectionSite query()
 * @method static Builder|SectionSite whereAnnounce($value)
 */
class SectionSite extends Model
{
    public $timestamps = false;

    protected $table = 'section_site';

    protected $fillable = ['site_id', 'section_id', 'to_section_id', 'from_site_id',
        'announce', 'moderated'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function fromSite(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function toSection(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function scopeSections($query, $siteId)
    {
        return $query->where('from_site_id', $siteId);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}