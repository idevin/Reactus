<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\SiteSection
 *
 * @property int $id
 * @property int $site_id
 * @property int $section_id
 * @property int $template_id
 * @property int $active
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\Template $template
 * @method static Builder|\App\Models\SiteSection whereActive($value)
 * @method static Builder|\App\Models\SiteSection whereId($value)
 * @method static Builder|\App\Models\SiteSection whereSectionId($value)
 * @method static Builder|\App\Models\SiteSection whereSiteId($value)
 * @method static Builder|\App\Models\SiteSection whereTemplateId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\SiteSection newModelQuery()
 * @method static Builder|\App\Models\SiteSection newQuery()
 * @method static Builder|\App\Models\SiteSection query()
 */
class SiteSection extends Model
{
    public $timestamps = false;

    protected $table = 'site_section';

    protected $fillable = array('site_id', 'section_id', 'active', 'template_id');

    public static function check($sectionId)
    {
        $siteSection = self::where('section_id', $sectionId)
            ->with(['site', 'template', 'section'])->get()->first();

        return $siteSection;
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function rootSection()
    {
        return (new Section)->whereNull('parent_id')->where('site_id', $this->site_id)->first();
    }
}