<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Robots;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Utils;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RobotsTxtParser;

class RobotoEditor extends Controller
{
    /**
     * @activity done
     */
    use Utils;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Robots::class);
        $this->setUserActivity();
        $this->setActionsExcluded(['update']);
    }

    const FILE_NAME = 'robots.txt';

    /**
     * @api {POST} /api/robots/show  Вывод файла robots.txt
     * @apiGroup SEO module
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(): JsonResponse
    {
        $sPathToFile = $this->getFullFilePath();

        if (!$this->checkFileExist($sPathToFile)) {
            return $this->getErrorResponse();
        }

        $sFileData = file_get_contents($sPathToFile);

        return $this->success($sFileData);
    }

    /**
     * @api {POST} /api/robots/update  Обновление файла robots.txt
     * @apiGroup SEO module
     *
     * @apiParam {string} data Контент файла robots.txt
     *
     * @param Request $obRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $obRequest): JsonResponse
    {
        $sPathToFile = $this->getFullFilePath();

        if (!$this->checkFileExist($sPathToFile)) {
            return $this->getErrorResponse();
        }

        $sRobotsFileData = $obRequest->get('data');

        $sProcessedRobotsData = $this->validateData($sRobotsFileData);
        if (!is_string($sProcessedRobotsData)) {
            return $sProcessedRobotsData;
        }

        file_put_contents($sPathToFile, $sProcessedRobotsData);

        $this->setIsSystem(false);
        $this->setParams($sProcessedRobotsData);
        $this->createActivity();

        return $this->success($sProcessedRobotsData);
    }

    /**
     * @return string
     */
    protected function getFullFilePath(): string
    {
        $sPathToFile = getenv('DOCUMENT_ROOT') . DS . self::FILE_NAME;

        return $sPathToFile;
    }

    /**
     * @param string $sFilePath
     *
     * @return bool
     */
    protected function checkFileExist(string $sFilePath): bool
    {
        return file_exists($sFilePath);
    }

    /**
     * @return JsonResponse
     */
    protected function getErrorResponse(): JsonResponse
    {
        return $this->error("Файл не найден");
    }

    /**
     * @param string $sRequestData
     *
     * @return string|JsonResponse
     */
    protected function validateData(string $sRequestData)
    {
        $obParser = new RobotsTxtParser($sRequestData);
        $arRules = $obParser->getRules();

        if (empty($arRules)) {
            return $this->error("Пустые или невалидные данные");
        }

        $sProcessedRobotsData = $this->getRobotsString($arRules);

        if (empty($sProcessedRobotsData)) {
            return $this->error("Не возможно синхронизировать файл");
        }

        return $sProcessedRobotsData;
    }
}