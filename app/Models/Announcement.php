<?php namespace App\Models;

use App\Traits\Announcement as AnnouncementTrait;
use BadMethodCallException;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * Class Announcement
 *
 * @package App\Models
 * @method static Builder|Announcement byObject($sObjectClass, $iObjectID = null)
 * @method static Builder|Announcement newModelQuery()
 * @method static Builder|Announcement newQuery()
 * @method static Builder|Announcement query()
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
 * @method static Builder|Announcement bySite($siteId)
 * @method static Builder|Announcement whereAnnounceId($value)
 * @method static Builder|Announcement whereAnnounceType($value)
 * @method static Builder|Announcement whereCreatedAt($value)
 * @method static Builder|Announcement whereDescription($value)
 * @method static Builder|Announcement whereId($value)
 * @method static Builder|Announcement whereObjectId($value)
 * @method static Builder|Announcement whereObjectType($value)
 * @method static Builder|Announcement whereSiteId($value)
 * @method static Builder|Announcement whereTitle($value)
 * @method static Builder|Announcement whereUpdatedAt($value)
 * @method static firstOrCreate(array $announcementData)
 */
class Announcement extends Model
{
    use AnnouncementTrait;

    public static array $classesList = [
        Article::class, Section::class, BlogArticle::class, BlogSection::class,
        Comment::class, BlogComment::class
    ];
    protected $table = "announcement";
    protected $fillable = [
        'title',
        'description',
        'object_type',
        'object_id',
        'site_id',
        'announce_type',
        'announce_id'
    ];

    /**
     * @param $ids
     */
    public static function deleteAll($ids)
    {
        if (is_array($ids)) {
            $ids = array_column($ids, 1);
            self::query()->whereIn('id', array_values($ids))->delete();
        }
    }

    /**
     * @param Section|Article $object
     * @param $announce
     * @return bool
     */
    public static function hasRelation(Section|Article $object, $announce): bool
    {
        $related = last(preg_split('/\\\/', get_class($announce)));
        $related = strtolower($related) . 's';

        try {
            $found = $object->$related()->whereId($announce->id)->first();
            if ($found) {
                return true;
            }

        } catch (BadMethodCallException $exception) {
            if (env('APP_DEBUG_VARS') == true) {
                debugvars('Announce error ', [$exception->getTraceAsString()]);
            }
            return false;
        }

        return false;
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function announce(): MorphTo
    {
        return $this->morphTo();
    }
}