<?php namespace App\Models;

use App\Traits\Announcement;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Vinelab\NeoEloquent\Eloquent\Relations\MorphTo;

/**
 * Class Announcement
 *
 * @package App\Models
 * @method static Builder|\App\Models\Announcement byObject($sObjectClass, $iObjectID = null)
 * @method static Builder|\App\Models\Announcement newModelQuery()
 * @method static Builder|\App\Models\Announcement newQuery()
 * @method static Builder|\App\Models\Announcement query()
 * @mixin Eloquent
 * @property int $id
 * @property int $object_id
 * @property string $object_type
 * @property string $title
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $site_id
 * @property string $announce_type
 * @property int $announce_id
 * @property-read \Illuminate\Database\Eloquent\Model|Eloquent $announce
 * @property-read \App\Models\Site $site
 * @method static Builder|\App\Models\Announcement bySite($siteId)
 * @method static Builder|\App\Models\Announcement whereAnnounceId($value)
 * @method static Builder|\App\Models\Announcement whereAnnounceType($value)
 * @method static Builder|\App\Models\Announcement whereCreatedAt($value)
 * @method static Builder|\App\Models\Announcement whereDescription($value)
 * @method static Builder|\App\Models\Announcement whereId($value)
 * @method static Builder|\App\Models\Announcement whereObjectId($value)
 * @method static Builder|\App\Models\Announcement whereObjectType($value)
 * @method static Builder|\App\Models\Announcement whereSiteId($value)
 * @method static Builder|\App\Models\Announcement whereTitle($value)
 * @method static Builder|\App\Models\Announcement whereUpdatedAt($value)
 */
class NeoAnnouncement extends Neo4j
{
    use Announcement;

    public static array $classesList = [
        Article::class, Section::class, NeoCard::class,
        BlogArticle::class, BlogSection::class, Comment::class, BlogComment::class
    ];
    public $timestamps = true;
    protected $label = "Announce";
    protected $connection = 'neo4j';
    protected $fillable = [
        'title',
        'description',
        'object_type',
        'object_id',
        'site_id',
        'announce_type',
        'announce_id'
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function announce(): MorphTo
    {
        return $this->morphTo();
    }
}