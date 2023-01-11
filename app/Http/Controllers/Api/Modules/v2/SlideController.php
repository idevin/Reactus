<?php

namespace App\Http\Controllers\Api\Modules\v2;

use App\Http\Controllers\Controller;
use App\Models\Modules\ModuleSlide;
use App\Models\Modules\ModuleSlider;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Media;
use App\Traits\Module;
use App\Traits\Slide;
use Auth;
use Exception;
use Illuminate\Http\JsonResponse;
use Session;
use Symfony\Component\HttpFoundation\Request;

class SlideController extends Controller
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

        $this->setObject(ModuleSlide::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['delete']);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/modules/v2/slide/add_or_update добавление обновление слайда (v2)
     * @apiGroup Module slide (v2)
     *
     * @apiParam {array} slides Массив слайдов с полями ниже: slides[0][sort_order], slides[0][url],
     * slides[0][title] и тд...
     * @apiParam {string} token ключ пользователя
     * @apiParam {Text} url URL для слайдера
     * @apiParam {string} title Название
     * @apiParam {string} short_description Краткое описание
     * @apiParam {Boolean} slider_type Тип слайдера: 1 - статический, 2 - динамический
     * @apiParam {Boolean} content_type Тип контента: 1 - статьи, 2 - разделы
     * @apiParam {Boolean} sort_by Сортировка, 1 - дата публикации, 2 - рейтинг, 3 - количество просмотров
     * @apiParam {Boolean} sort_order Направление сортировки, 1 - ASC, 2 - DESC
     * @apiParam {integer} slides_count Кол-во слайдов в одной группе динамического слайда
     * @apiParam {Boolean} period Период, за который будут браться статьи и разделы или еще какой контент.
     * 1 - за день, 2 - за неделю, 3 - за месяц, 4 - свой вариант выборки
     * @apiParam {DateTime} period_start Дата начала промежутка выборки
     * @apiParam {DateTime} period_end Дата конца промежутка выборки
     * @apiParam {Boolean} publish Дата публикации, 1 - день, 2 - неделя, 3 - месяц, 4 - свой вариант дат
     * @apiParam {DateTime} publish_start Дата начала действия слайдера
     * @apiParam {DateTime} publish_end Дата конца дейтсвия слайдера
     * @apiParam {Boolean} submodule 1 - сабмодуль, 0 - нет
     * @apiParam {Boolean} show_statistic 1 - да, 0 - нет
     * @apiParam {array} module_slide_sort_order Сортировка слайдов внутри слайдера. Массив: [1...100]
     * @apiParam {integer} id ID слайда
     * @apiParam {integer} module_slider_id ID слайдера
     */
    public function addOrUpdate(Request $request)
    {
        $data = $request->all();

        if(!isset($data['module_slider_id'])) {
            return $this->error('Не задан ID слайдера');
        }

        $slider = ModuleSlider::query()->find($data['module_slider_id']);

        if (!$slider) {
            return $this->error('Слайдер не найден');
        }

        $moduleSlide = self::createSlide($data, $slider);

        return $this->success($moduleSlide);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @throws Exception
     * @api {POST} /api/modules/slide/delete Удаление слайда (v2)
     * @apiGroup Module slide (v2)
     *
     * @apiParam {string} token ключ пользователя
     * @apiParam {integer} id ID слайда
     *
     */
    public function delete(Request $request)
    {
        $id = $request->get('id');
        if (!$id) {
            return $this->error('Не задан параметр ID');
        }

        $slide = ModuleSlide::query()->find($id);

        if (!$slide) {
            return $this->error('Слайдер не найден');
        }

        $this->setIsSystem(false);
        $this->setParams($slide->toArray());
        $this->createActivity();

        $slide->delete();

        ModuleSlide::flushCache();

        return $this->success();
    }

}