<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\Community;
use App\Models\Section;
use App\Models\SectionSetting;
use App\Models\SectionStorageImage;
use App\Models\SectionUser;
use App\Models\Site;
use App\Models\SiteSection;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Article as ArticleTrait;
use App\Traits\Media;
use App\Traits\Section as SectionTrait;
use Exception;
use GraphAware\Neo4j\Client\Exception\Neo4jExceptionInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;
use Symfony\Component\HttpFoundation\Request;

class SectionsController extends Controller
{
    /**
     * @activity done
     */

    use SectionTrait;
    use Media;
    use Activity;

    public static User|null $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Section::class);
        $this->setFromObject(User::class);
        $this->setFromObjectId(\Auth::user() ? \Auth::user()->id : null);
        $this->setIsApi(true);
        $this->setIsSystem(true);
        $this->setActivityUser(\Auth::user());
        $this->setActivityFromUser(\Auth::user());
        $this->setActionsExcluded(['create', 'delete', 'massDelete', 'update']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @internal param Request $request
     * @api {GET} /api/sections/slug Генерация ссылки
     * @apiGroup Sections
     *
     * @apiParam {string} term - символы для алиаса
     * @apiParam {string} token  - Токен ключ пользователя
     * @apiParam {string} section_id  - ID раздела (необязательное поле)
     */
    public function slug(Request $request): JsonResponse
    {
        return $this->getSectionSlug($request, Section::class);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/sections/site Список разделов по сайту
     * @apiGroup Sections
     *
     * @apiParam {integer} site_id ID сайта
     * @apiParam {string} token Токен ключ пользователя
     *
     * @internal param Request $request
     */
    public function site(Request $request): bool|JsonResponse|string
    {
        $siteId = $request->get('site_id', null);
        if (!$siteId) {
            return $this->error('Не найден параметр site_id');
        }

        $site = Site::thematic()->whereNotNull('site.parent_id')->find($siteId);
        if (!$site) {
            return $this->error('Сайт не найден...');
        }

        $sections = Section::getTreeOptions($site);
        $data['sections'] = $sections;

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/sections Список всех разделов
     * @apiGroup Sections
     *
     * @internal param int $id
     * @internal param Request $request
     * @internal param Request $request
     */
    public function index(Request $request): JsonResponse
    {
        if (Auth::guest() && !self::canAnon('section_view')) {
            return $this->error('Вы не можете просматривать раздел');
        }

        return $this->getSectionsIndex($request, Section::class,
            SectionSetting::class, Article::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {GET} /api/sections/sort Сортировка
     * @apiGroup Sections
     *
     * @apiParam {integer} section_id Id раздела
     * @apiParam {string} term Поиск по разделам
     * @apiParam {integer} page Страница для пагинатора
     * @apiParam {string} field Поле для сортировки
     * @apiParam {string} order Сортировка по возрастанию, по убыванию
     * @apiParam {string} view Вывод списком или сеткой (1 - сетка, 0 - список)
     *
     *
     */
    public function sort(Request $request): JsonResponse
    {
        return $this->sortSections($request, Section::class);
    }

    /**
     * @param Request $request
     * @param null $section
     * @param null $id
     * @return JsonResponse
     * @api {GET} /api/section/{alias}-{id} Просмотр раздела
     * @apiGroup Sections
     *
     * @internal param int $id
     */
    public function show(Request $request, $section = null, $id = null): JsonResponse
    {
        if (Auth::guest() && !self::canAnon('section_view')) {
            return $this->error('Вы не можете просматривать этот раздел');
        }

        return $this->showSection($request, SectionUser::class, Section::class,
            SiteSection::class, SectionSetting::class, Article::class, Site::class,
            $id, $section);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/sections/create Создание раздела
     * @apiGroup Sections
     *
     * @apiParam {string} title  Название раздела
     * @apiParam {integer} parent_id родитель раздела
     * @apiParam {string} token token пользователя
     * @apiParam {Text} [content]  Описание
     * @apiParam {Image} [images] картинки для раздела
     * @apiParam {Boolean} [filter_articles] выводить фильтр статей
     * @apiParam {Boolean} [filter_sections] выводить фильтр разделов
     * @apiParam {Boolean} [show_rating] показывать рейтинг раздела
     * @apiParam {Boolean} [show_article_author] показывать автора статей
     * @apiParam {Boolean} [hide_section_tags] скрывать теги раздела в списке разделов
     * @apiParam {Boolean} [show_opened] Оставлять раздел открытым (0 - нет, 1 - да)
     * @apiParam {string} [filter_articles_sort] сортировка статей по умолчанию
     * @apiParam {string} [filter_articles_sort_direction] направление сортировки статей
     * @apiParam {string} [filter_articles_view] вид статей по умолчанию
     * @apiParam {string} [articles_limit] лимит статей на страницу
     *
     * @apiParam {string} [filter_sections_sort] сортировка разделов по умолчанию
     * @apiParam {string} [filter_sections_sort_direction] направление сортировки разделов
     * @apiParam {string} [filter_sections_view] вид разделов по умолчанию
     * @apiParam {string} [sections_limit] лимит разделов на страницу
     *
     * @apiParam {Boolean} [is_secret] скрыть раздел
     * @apiParam {string} [tags] метки через запятую
     * @apiParam {array} [filter_settings] фильтр для каталога
     * @apiParam {array} [sort_options] сортировка для каталога
     * @apiParam {integer} [object_id] ID паттерна карточки
     *
     */
    public function create(Request $request)
    {
        return $this->createSection($request, Section::class, SectionUser::class,
            SectionSetting::class, SectionStorageImage::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Neo4jExceptionInterface
     * @api {GET} /api/sections/form Опции формы для раздела
     * @apiGroup Sections
     *
     * @apiParam {string} token User token
     * @apiParam {string} section_id Section id to edit (optional)
     *
     * @internal param Request $request
     */
    public function form(Request $request)
    {
        return $this->getSectionForm($request, Section::class, SectionSetting::class, Article::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/sections/update Обновление раздела
     * @apiGroup Sections
     *
     * @apiParam {integer} id  ID раздела для обновления
     * @apiParam {string} title  Название раздела
     * @apiParam {integer} parent_id родитель раздела
     * @apiParam {string} token token пользователя
     * @apiParam {integer} [other_section_id] ID раздела для другого ресурса
     * @apiParam {Text} [content]  Описание
     * @apiParam {Image} [images] картинки для раздела
     * @apiParam {Boolean} [filter_articles] выводить фильтр статей
     * @apiParam {Boolean} [filter_sections] выводить фильтр разделов
     * @apiParam {Boolean} [show_rating] показывать рейтинг раздела
     * @apiParam {Boolean} [show_article_author] показывать автора статей
     * @apiParam {Boolean} [hide_section_tags] скрывать теги раздела в списке разделов
     * @apiParam {Boolean} [show_opened] Оставлять раздел открытым (0 - нет, 1 - да)
     * @apiParam {string} [filter_articles_sort] сортировка статей по умолчанию
     * @apiParam {string} [filter_articles_sort_direction] направление сортировки статей
     * @apiParam {string} [filter_articles_view] вид статей по умолчанию
     * @apiParam {string} [articles_limit] лимит статей на страницу
     * @apiParam {string} [filter_sections_sort] сортировка разделов по умолчанию
     * @apiParam {string} [filter_sections_sort_direction] направление сортировки разделов
     * @apiParam {string} [filter_sections_view] вид разделов по умолчанию
     * @apiParam {string} [sections_limit] лимит разделов на страницу
     * @apiParam {Boolean} [is_secret] скрыть раздел
     * @apiParam {string} [tags] метки через запятую
     * @apiParam {array} [filter_settings] фильтр для каталога
     * @apiParam {array} [sort_options] сортировка для каталога
     * @apiParam {integer} [object_id] ID каталога
     *
     */
    public function update(Request $request): JsonResponse
    {
        return $this->updateSection($request, Section::class, SectionUser::class,
            SectionSetting::class, SectionStorageImage::class);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @api {POST} /api/sections/delete Удаление раздела
     * @apiGroup Sections
     *
     * @apiParam {integer} id ID раздела для удаления
     * @apiParams {string} token Token пользователя
     *
     *
     * @internal param $id
     * @internal param Request $request
     */
    public function delete(Request $request)
    {
        return $this->deleteSection($request, Section::class);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|Json|string
     * @api {GET} /api/sections/section Выборка всех разделов и статей
     * @apiGroup Sections
     *
     * @apiParam {integer} id ID раздела
     * @apiParams {string} token Token пользователя
     *
     *
     * @internal param $id
     * @internal param Request $request
     */
    public function section(Request $request)
    {
        $id = $request->get('id', null);

        $articlesIds = [];

        if (empty($id)) {
            return $this->error('Не задан параметр id');
        }

        $section = Section::query()->find($id);

        if (!$section) {
            return $this->error('Раздел не найден');
        }

        $children = $section->getDescendants();

        if (count($section->articles) > 0) {
            $section->articles->map(function ($article) use (&$articlesIds) {
                $articlesIds[] = $article->id;
            });
        }

        if (count($children) > 0) {
            $sectionIds = $children->map(function ($child) use (&$articlesIds) {

                if (count($child->articles) > 0) {
                    $child->articles->map(function ($article) use (&$articlesIds) {
                        $articlesIds[] = $article->id;
                    });
                }

                return $child->id;
            });
        } else {
            $sectionIds = [];
        }

        $data['sections'] = $sectionIds;
        $data['articles'] = $articlesIds;

        return $this->success($data);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|Json|string
     * @throws Exception
     * @internal param $id
     * @internal param Request $request
     * @api {POST} /api/sections/mass_delete массовое удаление разделов
     * @apiGroup Sections
     *
     * @apiParam {array} ids массив ID разделов
     * @apiParams {string} token Token пользователя
     *
     */
    public function massDelete(Request $request)
    {
        $ids = $request->get('ids');

        if (empty($ids) || is_string($ids)) {
            return $this->error('Не задан параметр ids или неверный формат массива');
        }

        $announces = [];
        $idsOnly = [];

        self::announcesMap($ids, $announces, $idsOnly);

        Announcement::deleteAll($announces);

        foreach ($idsOnly as $id) {
            $section = Section::query()->find($id);
            $section?->delete();
        }

        return $this->success();
    }
}