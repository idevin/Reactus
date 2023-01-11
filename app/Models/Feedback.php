<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Watson\Rememberable\Rememberable;

/**
 * Class Feedback
 *
 * @package App\Models
 * @property int $sort_order
 * @method static Builder sorted()
 * @property int $id
 * @property int $site_id
 * @property int $field_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $for_all_sites
 * @property-read \App\Models\Field $field
 * @property-read \App\Models\Site $site
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereForAllSites($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Feedback whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Feedback extends Model
{
    use Rememberable;


    public static $md5Alias = true;
    public $timestamps = true;
    public $rememberCacheTag = self::class;
    protected $table = 'feedback';
    protected $fillable = ['site_id', 'field_id', 'content', 'for_all_sites', 'sort_order'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * @param $query
     * @param string $mode
     * @return mixed
     */
    public function scopeSorted($query, $mode = 'asc')
    {
        return $query->orderBy('sort_order', $mode);
    }
}
