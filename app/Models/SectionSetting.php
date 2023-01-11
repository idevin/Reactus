<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\SectionSetting
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
 * @property int $hide_section_tags
 * @property int $hide_article_author_inside
 * @property string|null $sections_name
 * @property string|null $articles_name
 * @property int $rotate_slides
 * @property int $show_background
 * @property string|null $seo_title
 * @property string|null $seo_breadcrumbs
 * @property string|null $seo_description
 * @property-read \App\Models\Section $section
 * @method static Builder|\App\Models\SectionSetting newModelQuery()
 * @method static Builder|\App\Models\SectionSetting newQuery()
 * @method static Builder|\App\Models\SectionSetting query()
 * @method static Builder|\App\Models\SectionSetting whereArticlesLimit($value)
 * @method static Builder|\App\Models\SectionSetting whereArticlesName($value)
 * @method static Builder|\App\Models\SectionSetting whereCreatedAt($value)
 * @method static Builder|\App\Models\SectionSetting whereFilterArticles($value)
 * @method static Builder|\App\Models\SectionSetting whereFilterArticlesSort($value)
 * @method static Builder|\App\Models\SectionSetting whereFilterArticlesSortDirection($value)
 * @method static Builder|\App\Models\SectionSetting whereFilterArticlesView($value)
 * @method static Builder|\App\Models\SectionSetting whereFilterSections($value)
 * @method static Builder|\App\Models\SectionSetting whereFilterSectionsSort($value)
 * @method static Builder|\App\Models\SectionSetting whereFilterSectionsSortDirection($value)
 * @method static Builder|\App\Models\SectionSetting whereFilterSectionsView($value)
 * @method static Builder|\App\Models\SectionSetting whereHideArticleAuthorInside($value)
 * @method static Builder|\App\Models\SectionSetting whereHideSectionTags($value)
 * @method static Builder|\App\Models\SectionSetting whereId($value)
 * @method static Builder|\App\Models\SectionSetting whereRotateSlides($value)
 * @method static Builder|\App\Models\SectionSetting whereSectionId($value)
 * @method static Builder|\App\Models\SectionSetting whereSectionsLimit($value)
 * @method static Builder|\App\Models\SectionSetting whereSectionsName($value)
 * @method static Builder|\App\Models\SectionSetting whereSeoBreadcrumbs($value)
 * @method static Builder|\App\Models\SectionSetting whereSeoDescription($value)
 * @method static Builder|\App\Models\SectionSetting whereSeoTitle($value)
 * @method static Builder|\App\Models\SectionSetting whereShowArticleAuthor($value)
 * @method static Builder|\App\Models\SectionSetting whereShowBackground($value)
 * @method static Builder|\App\Models\SectionSetting whereShowRating($value)
 * @method static Builder|\App\Models\SectionSetting whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $show_opened
 * @method static Builder|\App\Models\SectionSetting whereShowOpened($value)
 */
class SectionSetting extends Model
{

    public static array $sortOptions = [
        'rating' => 'Рейтинг',
        'title' => 'Заголовок',
        'published-at' => 'Дата публикации',
        'articles' => 'Кол-во статей'
    ];
    public static array $viewOptions = [
        0 => 'Список',
        1 => 'Сетка'
    ];
    public $timestamps = true;
    protected $table = 'section_settings';
    protected $fillable = [
        'section_id', 'filter_articles', 'filter_articles_sort', 'filter_articles_sort_direction',
        'filter_sections', 'filter_sections_sort', 'filter_sections_sort_direction', 'filter_articles_view',
        'filter_sections_view', 'articles_limit', 'sections_limit', 'show_rating', 'show_article_author',
        'hide_section_tags', 'hide_article_author_inside', 'sections_name', 'articles_name', 'rotate_slides',
        'show_background', 'seo_breadcrumbs', 'seo_description', 'seo_title'
    ];
    protected array $sortable = [
        'title' => 'title',
        'articles' => 'articles_cnt',
        'rating' => 'rating',
        'members' => 'members_cnt',
        'published-at' => 'created_at'
    ];
    protected array $directions = ['asc', 'desc'];

    public static function saveFromRequest($requestData, $section)
    {
        if (isset($requestData['filter_articles'])) {
            $requestData['filter_articles'] = (int)$requestData['filter_articles'];
        } else {
            $requestData['filter_articles'] = 0;
        }

        if (isset($requestData['filter_sections'])) {
            $requestData['filter_sections'] = (int)$requestData['filter_sections'];
        } else {
            $requestData['filter_sections'] = 0;
        }

        if (isset($requestData['show_rating'])) {
            $requestData['show_rating'] = (int)$requestData['show_rating'];
        } else {
            $requestData['show_rating'] = 0;
        }

        if (isset($requestData['show_article_author'])) {
            $requestData['show_article_author'] = (int)$requestData['show_article_author'];
        } else {
            $requestData['show_article_author'] = 0;
        }

        $requestData['section_id'] = $section->id;

        $sectionSetting = SectionSetting::whereSectionId($section->id)->first();

        if (!$sectionSetting) {
            self::query()->create($requestData);
        } else {
            $sectionSetting->update($requestData);
        }
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}