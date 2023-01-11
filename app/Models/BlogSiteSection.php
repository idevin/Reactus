<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\BlogSiteSection
 *
 * @property int $id
 * @property int $site_id
 * @property int $section_id
 * @property int $template_id
 * @property int $active
 * @property-read \App\Models\BlogSection $section
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\Template $template
 * @method static Builder|\App\Models\BlogSiteSection whereActive($value)
 * @method static Builder|\App\Models\BlogSiteSection whereId($value)
 * @method static Builder|\App\Models\BlogSiteSection whereSectionId($value)
 * @method static Builder|\App\Models\BlogSiteSection whereSiteId($value)
 * @method static Builder|\App\Models\BlogSiteSection whereTemplateId($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\BlogSiteSection newModelQuery()
 * @method static Builder|\App\Models\BlogSiteSection newQuery()
 * @method static Builder|\App\Models\BlogSiteSection query()
 */
class BlogSiteSection extends Model
{
    public $timestamps = false;

    protected $table = 'blog_site_section';


    protected $fillable = array('site_id', 'section_id', 'active', 'template_id');

    public static function check($sectionId)
    {
        $siteSection = self::where('section_id', $sectionId)
            ->with(['site', 'template', 'section'])->get()->first();

        return $siteSection;
    }

    public function site()
    {
        return $this->belongsTo(BlogSite::class, 'site_id');
    }

    public function section()
    {
        return $this->belongsTo(BlogSection::class, 'section_id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function rootSection()
    {
        return (new BlogSection)->whereNull('parent_id')->whereSiteId($this->site_id)->first();
    }
}