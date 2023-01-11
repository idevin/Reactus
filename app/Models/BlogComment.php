<?php

namespace App\Models;

use App\Contracts\Rating;
use App\Models\Rating as RatingModel;
use App\Traits\Comment as CommentTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Input;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\BlogComment
 *
 * @property int $id
 * @property string $content
 * @property string|null $react_data
 * @property int $author_id
 * @property int $rating
 * @property string $object
 * @property int $object_id
 * @property int $site_id
 * @property int $status
 * @property int $pinned
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $top
 * @property int $moderated
 * @property int|null $parent_id
 * @property int|null $moderator_id
 * @property-read BlogArticle $article
 * @property-read User $author
 * @property-read Collection|BlogComment[] $children
 * @property-read mixed $origin
 * @property-read User|null $moderator
 * @property-read BlogComment|null $parent
 * @property-read BlogSection $section
 * @property-read Site $site
 * @method static Builder|BlogComment bySite($siteId)
 * @method static Builder|BlogComment onModeration()
 * @method static Builder|BlogComment whereAuthorId($value)
 * @method static Builder|BlogComment whereContent($value)
 * @method static Builder|BlogComment whereCreatedAt($value)
 * @method static Builder|BlogComment whereId($value)
 * @method static Builder|BlogComment whereModerated($value)
 * @method static Builder|BlogComment whereModeratorId($value)
 * @method static Builder|BlogComment whereObject($value)
 * @method static Builder|BlogComment whereObjectId($value)
 * @method static Builder|BlogComment whereParentId($value)
 * @method static Builder|BlogComment wherePinned($value)
 * @method static Builder|BlogComment whereRating($value)
 * @method static Builder|BlogComment whereReactData($value)
 * @method static Builder|BlogComment whereSiteId($value)
 * @method static Builder|BlogComment whereStatus($value)
 * @method static Builder|BlogComment whereTop($value)
 * @method static Builder|BlogComment whereUpdatedAt($value)
 * @method static Builder|BlogComment newModelQuery()
 * @method static Builder|BlogComment newQuery()
 * @method static Builder|BlogComment query()
 * @mixin Eloquent
 * @property-read int|null $children_count
 * @property-read Collection|\App\Models\Announcement[] $announcements
 * @property-read int|null $announcements_count
 * @property-read Collection|\App\Models\Announcement[] $announces
 * @property-read int|null $announces_count
 * @property-read int $announce
 * @property \App\Models\Announcement|null $announce_object
 * @method static Builder|BlogComment announced($id, $objectClass, $modelClass, $term = null)
 */
class BlogComment extends Model implements Rating
{
    use CommentTrait;

    const STATUS_APPROVED = 0;
    const STATUS_ON_MODERATION = 1;

    public $timestamps = true;
    protected $connection = 'mysql';
    protected $table = 'blog_comment';
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

    public function article(): BelongsTo
    {
        return $this->belongsTo(BlogArticle::class, 'object_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function complains($id, $status)
    {
        return Complain::whereObject(BlogComment::class)->whereObjectId($id)->whereStatus($status)->get();
    }

    public function object()
    {
        $object = $this->object;

        return $object::find($this->object_id);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(BlogComment::class, 'id', 'parent_id');
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function save(array $options = array()): bool
    {
        $this->updated_at = null;
        parent::save();
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(BlogSection::class, 'section_id');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(BlogSite::class, 'site_id');
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
        $link .= route_to_article($this->article, true, true);
        $link .= '#c' . $this->id . '">';
        $link .= $this->content;
        $link .= '</a>';

        return ['objectType' => BlogComment::class, 'data' => $link];
    }

    public static function calculateRating($object)
    {
        // TODO: Implement calculateRating() method.
    }
}