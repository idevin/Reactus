<?php

namespace App\Models;

use App\Traits\Moderation;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\Complain
 *
 * @property int $id
 * @property int $complain_option_id
 * @property int $user_id
 * @property int $on_user_id
 * @property string $content
 * @property string $object
 * @property int $object_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $parent_object_id
 * @property int $status
 * @property string $answer
 * @property int $moderator_id
 * @property-read \App\Models\ComplainOption $complain_option
 * @property-read \App\Models\User $moderator
 * @property-read \App\Models\User $on_user
 * @property-read \App\Models\User $user
 * @method static Builder|\App\Models\Complain newModelQuery()
 * @method static Builder|\App\Models\Complain newQuery()
 * @method static Builder|\App\Models\Complain onModeration()
 * @method static Builder|\App\Models\Complain query()
 * @method static Builder|\App\Models\Complain whereAnswer($value)
 * @method static Builder|\App\Models\Complain whereComplainOptionId($value)
 * @method static Builder|\App\Models\Complain whereContent($value)
 * @method static Builder|\App\Models\Complain whereCreatedAt($value)
 * @method static Builder|\App\Models\Complain whereId($value)
 * @method static Builder|\App\Models\Complain whereModeratorId($value)
 * @method static Builder|\App\Models\Complain whereObject($value)
 * @method static Builder|\App\Models\Complain whereObjectId($value)
 * @method static Builder|\App\Models\Complain whereOnUserId($value)
 * @method static Builder|\App\Models\Complain whereParentObjectId($value)
 * @method static Builder|\App\Models\Complain whereStatus($value)
 * @method static Builder|\App\Models\Complain whereUpdatedAt($value)
 * @method static Builder|\App\Models\Complain whereUserId($value)
 * @mixin Eloquent
 */
class Complain extends Model
{
    use Moderation;

    const STATUS_ON_MODERATION = 0;
    const STATUS_BANNED = 1;
    const STATUS_DENIED = 2;
    const STATUS_APPROVED = 3;

    public static array $types = [
        Article::class, Comment::class
    ];
    public $timestamps = true;
    protected $table = 'complain';
    protected $fillable = ['title', 'id', 'user_id', 'on_user_id', 'object', 'object_id', 'complain_option_id', 'content', 'parent_object_id', 'status', 'answer', 'moderator_id'];

    public static function statuses()
    {
        return [
            'onModeration' => static::STATUS_ON_MODERATION,
            'banned' => static::STATUS_BANNED,
            'canceled' => static::STATUS_DENIED,
            'approved' => static::STATUS_APPROVED
        ];
    }

    public function complain_option()
    {
        return $this->belongsTo(ComplainOption::class);
    }

    public function scopeOnModeration($query)
    {
        return $query->where(['status' => static::STATUS_ON_MODERATION]);
    }

    public function user()
    {
        $this->connection = 'mysqlu';
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function on_user()
    {
        $this->connection = 'mysqlu';
        return $this->belongsTo(User::class, 'on_user_id', 'id');
    }

    public function moderator()
    {
        $this->connection = 'mysqlu';
        return $this->belongsTo(User::class, 'moderator_id', 'id');
    }

    public function object()
    {
        $object = $this->object;

        return $object::find($this->object_id);
    }

    public function objectTypeContent()
    {
        return $this->getObjectType();
    }

    public function article($id): string
    {
        $data = Article::find($id);

        return '<a target="_blank" href="' . route_to_article($data) . '">' . $data->title . '</a>';
    }

    public function comment($id): string
    {
        return ModerationAnswer::comment($id);
    }
}