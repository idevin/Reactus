<?php

namespace App\Models;

use App\Traits\Moderation;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ModerationAnswer
 *
 * @property int $id
 * @property int $object_id
 * @property string $object
 * @property int $author_id
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $confirmed_at
 * @property-read \App\Models\User $author
 * @method static Builder|\App\Models\ModerationAnswer whereAuthorId($value)
 * @method static Builder|\App\Models\ModerationAnswer whereConfirmedAt($value)
 * @method static Builder|\App\Models\ModerationAnswer whereContent($value)
 * @method static Builder|\App\Models\ModerationAnswer whereCreatedAt($value)
 * @method static Builder|\App\Models\ModerationAnswer whereId($value)
 * @method static Builder|\App\Models\ModerationAnswer whereObject($value)
 * @method static Builder|\App\Models\ModerationAnswer whereObjectId($value)
 * @method static Builder|\App\Models\ModerationAnswer whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ModerationAnswer newModelQuery()
 * @method static Builder|\App\Models\ModerationAnswer newQuery()
 * @method static Builder|\App\Models\ModerationAnswer query()
 */
class ModerationAnswer extends Model
{
    use Moderation;

    public static array $types = [
        Article::class, Comment::class
    ];
    protected $table = 'moderation_answer';
    protected $fillable = ['author_id', 'content', 'object_id', 'object', 'confirmed_at'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function articles()
    {
        return ModerationAnswer::where(['object' => Article::class])->get();
    }

    public function comments()
    {
        return ModerationAnswer::where(['object' => Comment::class])->get();
    }

    public function url()
    {
        return $this->getObjectType();
    }

    public function article($id): string
    {
        $data = Article::query()->find($id);

        return '<a target="_blank" href="' . route_to_article($data) . '">' . $data->title . '</a>';
    }

    public static function comment($id): string
    {
        $data = Comment::query()->find($id);

        if (!$data) {
            return '&mdash;';
        }

        $html = 'URL: <a target="_blank" href="' . route_to_article($data->object()) . '#c' . $id . '">' . $data->object()->title . '</a><br>';
        $html .= $data->content;

        return $html;
    }

    public function object()
    {
        $object = $this->object;

        return $object::find($this->object_id);
    }
}
