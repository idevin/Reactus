<?php

namespace App\Models;

use App\Traits\Modules\Creators;
use App\Traits\Modules\Validators;
use App\Traits\Response;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Watson\Rememberable\Rememberable;


class PageStrokeModuleRevision extends Model
{
    use Rememberable;
    use SoftDeletes;
    use Validators;
    use Creators;
    use Response;

    public string $rememberCacheTag = self::class;

    protected $table = 'page_stroke_module_revision';
    public $timestamps = true;

    protected $guarded = [];

    protected $appends = ['module_object', 'data'];

    protected $casts = [
        'content_options' => 'array'
    ];

    protected $connection = 'mysql';

    public function stroke(): BelongsTo
    {
        return $this->belongsTo(PageStrokeRevision::class);
    }

    /**
     * @param $page
     * @return string|PageStroke|PageStrokeRevision
     * @todo DUPLICATED
     */
    public static function model($page)
    {
        $model = PageStrokeModule::class;

        if ((int)$page->is_edit_mode == 1) {
            $model = PageStrokeModuleRevision::class;
        }

        return app($model);
    }

    protected static function boot()
    {
        parent::boot();
        PageStrokeModuleRevision::creating(function ($pageRev) {
            PageStrokeModuleRevision::setCurrent($pageRev);
        });

        PageStrokeModuleRevision::updating(function ($pageRev) {
            PageStrokeModuleRevision::setCurrent($pageRev);
        });
    }

    public static function setCurrent($pageRev)
    {
        PageStrokeModuleRevision::query()->whereIsCurrent(1)->update([
            'is_current' => 0
        ]);

        $pageRev->is_current = 1;
    }

    public static function createModule(&$data)
    {
        $moduleName = self::getModuleName($data['module_class']);

        $method = 'create' . $moduleName;

        if (!method_exists(self::class, $method)) {
            $data['module_object'] = Response::response()->error('Не найден создатель для модуля');
            return $data;
        }

        $data['module_object'] = self::{$method}($data);

        if (!$data['module_object'] instanceof JsonResponse) {
            $data['module_id'] = $data['module_object']->id;
        }

        return $data;
    }

    public static function updateModule(&$data, $module)
    {
        $moduleName = self::getModuleName($data['module_class']);

        $method = 'update' . $moduleName;

        if (!method_exists(self::class, $method)) {
            $data['module_object'] = Response::response()->error('Не найден создатель для модуля');
            return $data;
        }

        $data['module_object'] = self::{$method}($data, $module);

        if (!$data['module_object'] instanceof JsonResponse) {
            $data['module_id'] = $data['module_object']->id;
        }

        return $data;
    }

    public static function createModuleValidator(&$data)
    {
        $data['errors'] = [];

        if (!isset($data['settings'])) {
            return $data;
        }

        $moduleName = last(explode("\\", $data['module_class']));
        $data['settings'] = json_decode($data['settings'], true);

        if (!$data['settings']) {
            $data['errors'] = 'Неверная JSON строка';
            return $data;
        }

        $method = 'create' . $moduleName . 'Validator';

        if (!method_exists(self::class, $method)) {
            $data['errors']['validator'][] = 'Не найден валидатор для модуля';
            return $data;
        }

        $validator = self::$method($data['settings']);

        if (is_string($validator)) {
            $data['errors'] = $validator;
        } elseif ($validator instanceof Validator && $validator->fails()) {
            $data['errors'] = $validator->errors();
        }

        return $data;
    }

    public function getModuleObjectAttribute()
    {
        $module = collect();

        if (!empty($this->module_class) && !empty($this->module_id)) {
            $module = app($this->module_class)->query()->whereId($this->module_id)->get();
        }

        return $module;
    }

    public function getDataAttribute()
    {
        $data = collect();

        if ($this->module_object && count($this->module_object) > 0) {
            $module = $this->module_object[0];
            $data = $module::getBlock($module);
        }

        return $data;
    }

    public static function getModuleName($module)
    {
        return last(explode("\\", $module));
    }
}
