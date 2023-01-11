<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\ArticleRevision
 *
 * @property int $id
 * @property int $article_id
 * @property string $title
 * @property string $content
 * @property string|null $react_data
 * @property int $count_symbols
 * @property int $count_images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $author_id
 * @property int $section_id
 * @property-read \App\Models\Article $article
 * @property-read \App\Models\User $author
 * @property-read \App\Models\Section $section
 * @method static Builder|\App\Models\ArticleRevision whereArticleId($value)
 * @method static Builder|\App\Models\ArticleRevision whereAuthorId($value)
 * @method static Builder|\App\Models\ArticleRevision whereContent($value)
 * @method static Builder|\App\Models\ArticleRevision whereCountImages($value)
 * @method static Builder|\App\Models\ArticleRevision whereCountSymbols($value)
 * @method static Builder|\App\Models\ArticleRevision whereCreatedAt($value)
 * @method static Builder|\App\Models\ArticleRevision whereId($value)
 * @method static Builder|\App\Models\ArticleRevision whereReactData($value)
 * @method static Builder|\App\Models\ArticleRevision whereSectionId($value)
 * @method static Builder|\App\Models\ArticleRevision whereTitle($value)
 * @method static Builder|\App\Models\ArticleRevision whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|\App\Models\ArticleRevision newModelQuery()
 * @method static Builder|\App\Models\ArticleRevision newQuery()
 * @method static Builder|\App\Models\ArticleRevision query()
 */
class ArticleRevision extends Model
{


    protected $table = 'article_revision';

    protected $fillable = ['article_id', 'title', 'content', 'count_symbols',
        'count_images', 'author_id', 'react_data', 'section_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
