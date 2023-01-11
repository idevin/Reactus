<?php

namespace App\Models;

use App\Contracts\Rating;
use App\Models\Rating as RatingModel;
use App\Traits\Announceable;
use App\Traits\Comment as CommentTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Input;
use JetBrains\PhpStorm\ArrayShape;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $content
 * @property int $author_id
 * @property int|null $moderator_id
 * @property float $rating
 * @property string $object
 * @property string|null $deleted_at
 * @property int|null $parent_id
 * @property int $object_id
 * @property int $moderated
 * @property int $top
 * @property int $status
 * @property int|null $site_id
 * @property int|null $pinned
 * @property string|null $react_data
 * @property-read \App\Models\Article $article
 * @property-read \App\Models\User $author
 * @property-read Collection|\App\Models\Comment[] $children
 * @property-read mixed $origin
 * @property-read \App\Models\User|null $moderator
 * @property-read \App\Models\Comment|null $parent
 * @property-read \App\Models\Section $section
 * @property-read \App\Models\Site|null $site
 * @method static Builder|\App\Models\Comment bySite($siteId)
 * @method static Builder|\App\Models\Comment newModelQuery()
 * @method static Builder|\App\Models\Comment newQuery()
 * @method static Builder|\App\Models\Comment onModeration()
 * @method static Builder|\App\Models\Comment query()
 * @method static Builder|\App\Models\Comment whereAuthorId($value)
 * @method static Builder|\App\Models\Comment whereContent($value)
 * @method static Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static Builder|\App\Models\Comment whereDeletedAt($value)
 * @method static Builder|\App\Models\Comment whereId($value)
 * @method static Builder|\App\Models\Comment whereModerated($value)
 * @method static Builder|\App\Models\Comment whereModeratorId($value)
 * @method static Builder|\App\Models\Comment whereObject($value)
 * @method static Builder|\App\Models\Comment whereObjectId($value)
 * @method static Builder|\App\Models\Comment whereParentId($value)
 * @method static Builder|\App\Models\Comment wherePinned($value)
 * @method static Builder|\App\Models\Comment whereRating($value)
 * @method static Builder|\App\Models\Comment whereReactData($value)
 * @method static Builder|\App\Models\Comment whereSiteId($value)
 * @method static Builder|\App\Models\Comment whereStatus($value)
 * @method static Builder|\App\Models\Comment whereTop($value)
 * @method static Builder|\App\Models\Comment whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read int|null $children_count
 * @property-read Collection|\App\Models\Announcement[] $announcements
 * @property-read int|null $announcements_count
 * @method static Builder|\App\Models\Comment announced($id, $objectClass, $modelClass)
 * @property-read mixed $announce
 * @property-read mixed $announce_object
 * @property-read Collection|\App\Models\Announcement[] $announces
 * @property-read int|null $announces_count
 * @method static Builder|Comment author()
 */
class Comment extends Model implements Rating
{
    use Rememberable;
    use Announceable;
    use CommentTrait;

    const STATUS_APPROVED = 0;
    const STATUS_ON_MODERATION = 1;

    public $timestamps = true;
    protected $connection = 'mysql';
    protected $table = 'comment';
    protected $fillable = [
        'content', 'object_id', 'object', 'author_id', 'top', 'pinned',
        'moderator_id', 'parent_id', 'moderated', 'status', 'site_id', 'react_data'
    ];
    protected $appends = [
        'origin'
    ];

    public static function ratingValues(): array
    {
        return ["+2", "+1", "-1", "-2"];
    }

    public static function calculateRating($object)
    {
        $objects = RatingModel::where('object_id', $object->id)->where('object', get_class($object))->get();
        $total = 0;
        $totalObjects = 0;
        foreach ($objects as $object) {
            if ($object->rating_value <> 0) {
                $total += $object->rating_value;
                $totalObjects += $totalObjects;
            }
        }

        if ($totalObjects > 0 && $total > 0) {
            $total = $total / $totalObjects;
        }

        return $total;
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'object_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function complains($id, $status)
    {
        return Complain::where('object', Comment::class)->where('object_id', $id)->where('status', $status)->get();
    }

    public function object()
    {
        $object = $this->object;

        return $object::find($this->object_id);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'id', 'parent_id');
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function save(array $options = array())
    {
        $this->updated_at = null;
        parent::save();
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function getContent()
    {
        $this->content = strip_tags($this->content);
    }


    public function url()
    {
        return null;
    }

    #[ArrayShape(['objectType' => "string", 'data' => "string"])]
    public function getContentArray(): array
    {
        $link = '<b>комментарий:</b> <a target="_blank" href="';
        $link .= route_to_article($this->article);
        $link .= '#c' . $this->id . '">';
        $link .= $this->content;
        $link .= '</a>';

        return ['objectType' => Comment::class, 'data' => $link];
    }
}