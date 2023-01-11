<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\BlogSectionSetting
 *
 * @property int $id
 * @property int $section_id
 * @property int|null $filter_articles
 * @property string|null $filter_articles_sort
 * @property string|null $filter_articles_sort_direction
 * @property int|null $filter_sections
 * @property string|null $filter_sections_sort
 * @property string|null $filter_sections_sort_direction
 * @property int|null $filter_articles_view
 * @property int|null $filter_sections_view
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $articles_limit
 * @property int|null $sections_limit
 * @property int $show_rating
 * @property int $show_article_author
 * @property int $rotate_slides
 * @property int $show_background
 * @property-read \App\Models\BlogSection $section
 * @method static Builder|\App\Models\BlogSectionSetting newModelQuery()
 * @method static Builder|\App\Models\BlogSectionSetting newQuery()
 * @method static Builder|\App\Models\BlogSectionSetting query()
 * @method static Builder|\App\Models\BlogSectionSetting whereArticlesLimit($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereCreatedAt($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereFilterArticles($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereFilterArticlesSort($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereFilterArticlesSortDirection($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereFilterArticlesView($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereFilterSections($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereFilterSectionsSort($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereFilterSectionsSortDirection($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereFilterSectionsView($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereId($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereRotateSlides($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereSectionId($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereSectionsLimit($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereShowArticleAuthor($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereShowBackground($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereShowRating($value)
 * @method static Builder|\App\Models\BlogSectionSetting whereUpdatedAt($value)
 * @mixin Eloquent
 */
class BlogSectionSetting extends Model
{


    public static $sortOptions = [
        'rating' => 'Рейтинг',
        'title' => 'Заголовок',
        'published-at' => 'Дата публикации',
        'articles' => 'Кол-во статей'
    ];
    public static $viewOptions = [
        0 => 'Список',
        1 => 'Сетка'
    ];
    public $timestamps = true;
    protected $table = 'blog_section_settings';
    protected $fillable = [
        'section_id', 'filter_articles', 'filter_articles_sort', 'filter_articles_sort_direction', 'filter_sections',
        'filter_sections_sort', 'filter_sections_sort_direction', 'filter_articles_view', 'filter_sections_view',
        'articles_limit', 'sections_limit', 'show_rating', 'show_article_author', 'rotate_slides', 'show_background'
    ];

    protected $sortable = [
        'title' => 'title',
        'articles' => 'articles_cnt',
        'rating' => 'rating',
        'members' => 'members_cnt',
        'published-at' => 'created_at'
    ];

    protected $directions = ['asc', 'desc'];

    public function section()
    {
        return $this->belongsTo(BlogSection::class, 'section_id');
    }
}