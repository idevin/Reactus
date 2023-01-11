<?php

namespace App\Models;

use App\Traits\Media;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ArticleImage
 *
 * @property int $id
 * @property int $article_id
 * @property string $image
 * @property string|null $title
 * @property string|null $description
 * @property-read \App\Models\Article $article
 * @property-read mixed $thumbs
 * @method static Builder|ArticleImage whereArticleId($value)
 * @method static Builder|ArticleImage whereDescription($value)
 * @method static Builder|ArticleImage whereId($value)
 * @method static Builder|ArticleImage whereImage($value)
 * @method static Builder|ArticleImage whereTitle($value)
 * @mixin Eloquent
 * @method static Builder|ArticleImage newModelQuery()
 * @method static Builder|ArticleImage newQuery()
 * @method static Builder|ArticleImage query()
 * @property-read mixed $image_url
 * @property mixed $images
 */
class ArticleImage extends Model
{
    use Media;

    public $timestamps = false;

    protected $table = 'article_images';

    protected $fillable = ['article_id', 'image', 'title', 'description'];

    protected $appends = [
        'thumbs'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function getThumbsAttribute(): array
    {
        $thumbs = [];
        if (!empty($this->image)) {
            foreach (config('image.thumb.article_slider') as $item) {

                $size = self::getSizes($item);

                $thumbs["thumb{$size}"] = $this->imageUrl($size, 'article_slider', $this->image);
            }
            $thumbs["original"] = $this->originalImageUrl('ariticle_slider', $this->image, $this->article->author);
        }

        return $thumbs;
    }
}
