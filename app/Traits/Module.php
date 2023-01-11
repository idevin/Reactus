<?php

namespace App\Traits;

use App\Models\Modules\Module as ModuleModel;
use App\Models\Page;
use App\Models\PageStroke;
use App\Models\ProfileModule;
use App\Models\ProfileModuleStroke;
use App\Models\ProfileModuleStrokeCell;
use JetBrains\PhpStorm\ArrayShape;

trait Module
{
    /**
     * @param $class
     * @param null $id
     * @return array
     */
    #[ArrayShape(['error' => "mixed|null", 'module' => "array"])]
    public static function checkModule($class, $id = null): array
    {
        $data = ['error' => null, 'module' => null];

        $response = new class {
            use Response;
        };

        $module = ModuleModel::query()->whereClass($class);

        if ($id) {
            $module = $module->whereId($id);
        }

        $module = $module->get()->first();

        if (!$module) {
            $data['error'] = $response->error('Модуль не найден или не связан с блоками');
        } else {
            $data['module'] = $module;
        }

        return $data;
    }

    public static function validateModel($validator, $data): array
    {
        if ($validator->fails()) {
            return Response::response()->error($validator->errors());
        }

        $page = Page::query()->find($data['page_id']);

        if (!$page) {
            return Response::response()->error('Страница не найдена');
        }

        $pageStroke = PageStroke::query()->find($data['page_stroke_id']);

        if (!$pageStroke) {
            return Response::response()->error('Строка не найдена');
        }

        return compact('page', 'pageStroke');
    }

    /**
     * @param array $requestData
     * @param ProfileModuleStroke $moduleStroke
     * @param bool $create
     * @return array
     */
    public function setCells($requestData, $moduleStroke, $create = true)
    {
        $cells = [];
        if (!empty($requestData)) {

            foreach ($requestData['cells'] as $index => $profileModuleId) {
                $profileModule = ProfileModule::query()->find($profileModuleId);

                if ($profileModule) {

                    $data = [
                        'profile_module_stroke_id' => $moduleStroke->id,
                        'index' => $index,
                        'profile_module_id' => $profileModule->id
                    ];

                    if ($create == true) {
                        $cells[] = ProfileModuleStrokeCell::firstOrCreate($data);
                    } else {
                        $profileModule->update($data);
                        $cells[] = $profileModule;
                    }
                }
            }
        }

        return $cells;
    }
}