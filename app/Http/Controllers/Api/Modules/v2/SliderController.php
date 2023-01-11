<?php

namespace App\Http\Controllers\Api\Modules\v2;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Modules\ModuleSlider;
use App\Models\Section;
use App\Traits\Activity;
use App\Traits\Media;
use App\Traits\Module;
use App\Traits\Slide;
use Auth;
use Illuminate\Http\JsonResponse;
use Session;
use Symfony\Component\HttpFoundation\Request;

class SliderController extends Controller
{
    /**
     * @activity done
     */
    public static $user = null;

    use Slide;
    use Module;
    use Media;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        if (!self::$user) {
            self::$user = Auth::user();
        }

        Session::forget('site');

        $this->setObject(ModuleSlider::class);
        $this->setUserActivity();
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/modules/v2/slider/validate Валидация слайдера (v2)
     * @apiGroup Module slider (v2)
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} sort_order направление сортировки (1 - по возрастанию, 2 - по убыванию)
     * @apiParam {string} name имя блока
     * @apiPAram {integer} slider_type Тип слайдера (1 - статический, 2 - динамический)
     * @apiParam {integer} url URL раздела или статьи (для статического слайдера)
     * @apiParam {string} image путь к картинке (для статического слайдера)
     * @apiParam {string} short_description краткое описание (для статического слайдера)
     * @apiParam {integer} section_id ID раздела
     * @apiParam {integer} article_id ID статьи
     * @apiParam {integer} slides_count количество слайдов (1-10 для динамического)
     * @apiParam {integer} content_type Тип контента (1 - статья, 2 - раздел)
     * @apiParam {integer} period выборка периода (1 - день, 2 - неделя, 3 - месяц, 4 - неограничено, 5 - свой
     * вариант выборки)
     * @apiParam {integer} publish период публикации (1 - день, 2 - неделя, 3 - месяц, 4 - выбор дат)
     * @apiParam {date} publish_start Начало публикации
     * @apiParam {date} publish_end Конец публикации
     */
    public function validateSlide(Request $request)
    {
        $data = $request->all();

        if (empty($data['name'])) {
            $data['name'] = 'Статический слайдер';
        }

        if (empty($data['slider_type'])) {
            return $this->error('Не задан типа слайдера');
        }

        if (!empty($data['section_id'])) {
            $section = Section::query()->find($data['section_id']);
            if (!$section) {
                return $this->error('Такой раздел не найден');
            }
        }

        if (!empty($data['article_id'])) {
            $article = Article::query()->find($data['article_id']);
            if (!$article) {
                return $this->error('Такая статья не найдена');
            }
        }

        return self::validator($data);
    }
}