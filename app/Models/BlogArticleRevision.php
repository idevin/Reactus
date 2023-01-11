<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\BlogArticleRevision
 *
 * @property int $id
 * @property int $article_id
 * @property string $title
 * @property string $content
 * @property int $count_symbols
 * @property int $count_images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $author_id
 * @property-read \App\Models\Article $article
 * @method static Builder|\App\Models\BlogArticleRevision whereArticleId($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereAuthorId($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereContent($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereCountImages($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereCountSymbols($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereCreatedAt($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereId($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereTitle($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string $react_data
 * @property int $section_id
 * @method static Builder|\App\Models\BlogArticleRevision newModelQuery()
 * @method static Builder|\App\Models\BlogArticleRevision newQuery()
 * @method static Builder|\App\Models\BlogArticleRevision query()
 * @method static Builder|\App\Models\BlogArticleRevision whereReactData($value)
 * @method static Builder|\App\Models\BlogArticleRevision whereSectionId($value)
 */
class BlogArticleRevision extends Model
{


    protected $table = 'blog_article_revision';

    protected $fillable = ['article_id', 'title', 'content', 'count_symbols', 'count_images', 'author_id'];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    protected function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
