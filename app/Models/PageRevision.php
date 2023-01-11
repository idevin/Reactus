<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\PageRevision
 *
 * @property int $id
 * @property int $page_id
 * @property int $action
 * @property string $name
 * @property int $is_current
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property array $params
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PageStroke[] $strokes
 * @property-read int|null $strokes_count
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision newQuery()
 * @method static \Illuminate\Database\Query\Builder|PageRevision onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereIsCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageRevision whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PageRevision withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PageRevision withoutTrashed()
 * @mixin \Eloquent
 */
class PageRevision extends Model
{
    use Rememberable;
    use SoftDeletes;

    public string $rememberCacheTag = self::class;
    public $timestamps = true;

    const ADD_PAGE = 0;
    const DELETE_PAGE = 1;
    const ADD_STROKE = 2;
    const DELETE_STROKE = 3;
    const SORT_STROKES = 4;
    const ADD_MODULE = 5;
    const DELETE_MODULE = 6;
    const SORT_MODULES = 7;
    const UPDATE_STROKE = 8;
    const UPDATE_MODULE = 9;
    const ACTIVE_STROKE = 10;
    const ACTIVE_MODULE = 11;
    const UNACTIVE_STROKE = 12;
    const UNACTIVE_MODULE = 13;

    public static array $actions = [
        self::ADD_PAGE => 'Добавление страницы',
        self::DELETE_PAGE => 'Удаление страницы',
        self::ADD_STROKE => 'Добавление строки',
        self::DELETE_STROKE => 'Удаление строки',
        self::SORT_STROKES => 'Сортировка строк',
        self::ADD_MODULE => 'Добавление модуля',
        self::DELETE_MODULE => 'Удаление модуля',
        self::SORT_MODULES => 'Сортировка модулей',
        self::UPDATE_STROKE => 'Обновление строки',
        self::UPDATE_MODULE => 'Обновление модуля',
        self::ACTIVE_STROKE => 'Активная строка',
        self::ACTIVE_MODULE => 'Активный модуль',
        self::UNACTIVE_STROKE => 'Неактивная строка',
        self::UNACTIVE_MODULE => 'Неактивный модуль'
    ];

    protected $table = 'page_revision';

    protected $fillable = [
        'name', 'page_id', 'is_current', 'action', 'created_at', 'updated_at', 'deleted_at', 'params'
    ];

    protected $casts = [
        'params' => 'json'
    ];

    protected $connection = 'mysql';


    /**
     * @param Page $page
     * @param int $action
     * @param null $params
     */
    public static function createRevision(Page $page, int $action, $params = null)
    {
        self::query()->whereIsCurrent(1)->update([
            'is_current' => 0
        ]);

        $paramsArray = $params->toArray();

        unset($paramsArray['data']);

        self::query()->firstOrCreate([
            'page_id' => $page->id,
            'action' => $action,
            'params' => json_encode($paramsArray),
            'is_current' => 1
        ]);
    }

    public function strokes(): HasMany
    {
        return $this->hasMany(PageStroke::class);
    }
}
