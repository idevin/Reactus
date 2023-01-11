<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Activity;
use App\Traits\Colors;
use App\Traits\Site as SiteTrait;
use Auth;
use Illuminate\Http\JsonResponse;
use Session;
use Validator;

class TimeController extends Controller
{
    /**
     * @activity done
     */
    use SiteTrait;
    use Activity;
    use Colors;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     * @api {GET} /api/time/utc/{UTC_STRING} Получение времени
     * @apiGroup Time
     * @apiParam {string} UTC_STRING временная зона (-+12)
     *
     */
    public function utc($utc): JsonResponse
    {
        if (!is_numeric($utc)) {
            return $this->error('Неверный параметр UTC');
        }

        $utc = (int)$utc;

        if (((-12 <= $utc) && ($utc <= 12)) === false) {
            return $this->error('Формат UTC должен быть межд промежутком -12 и 12');
        }

        if ((int)$utc >= 0 && !str_contains($utc, '+')) {
            $utc = '+' . $utc;
        }

        $date = new \DateTime(timezone: new \DateTimeZone($utc));
        $dateFormated = $date->format('Y-m-d H:i:s');
        $sec = strtotime($dateFormated);
        $ms = $sec * 1000;

        return $this->success([
            'sec' => $sec,
            'ms' => $ms,
            'date' => $dateFormated
        ]);
    }
}
