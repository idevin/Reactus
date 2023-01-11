<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property int $site_id
 * @property string|null $yandex_code
 * @property string|null $google_code
 * @property string|null $yandex_verification
 * @property string|null $google_verification
 * @property string|null $google_tag
 * @property-read \App\Models\Site $site
 * @method static Builder|\App\Models\Setting newModelQuery()
 * @method static Builder|\App\Models\Setting newQuery()
 * @method static Builder|\App\Models\Setting query()
 * @method static Builder|\App\Models\Setting whereGoogleCode($value)
 * @method static Builder|\App\Models\Setting whereGoogleTag($value)
 * @method static Builder|\App\Models\Setting whereGoogleVerification($value)
 * @method static Builder|\App\Models\Setting whereId($value)
 * @method static Builder|\App\Models\Setting whereSiteId($value)
 * @method static Builder|\App\Models\Setting whereYandexCode($value)
 * @method static Builder|\App\Models\Setting whereYandexVerification($value)
 * @mixin Eloquent
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_breadcrumbs
 * @method static Builder|\App\Models\Setting whereSeoBreadcrumbs($value)
 * @method static Builder|\App\Models\Setting whereSeoDescription($value)
 * @method static Builder|\App\Models\Setting whereSeoTitle($value)
 */
class Setting extends Model
{
    public $timestamps = false;
    public $rememberCacheTag = self::class;
    protected $table = 'settings';
    protected $fillable = ['site_id', 'yandex_code', 'google_code', 'template_id',
        'yandex_verification', 'google_verification', 'google_tag', 'seo_title', 'seo_description', 'seo_breadcrumbs'
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
