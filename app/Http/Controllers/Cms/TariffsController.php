<?php

namespace App\Http\Controllers\Cms;

use App\Models\BillingService;
use App\Models\BillingTariff;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

class TariffsController extends CmsController
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = [__('admin.tariffs'), ('cms.billing.tariffs.index')];
    }

    public function show()
    {

    }

    public function create()
    {
        $title = __('admin.add');
        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new BillingTariff();

        $action = 'cms.billing.tariffs.store';
        $periods = self::getPeriods();
        $services = self::getServices();

        return view('cms.tariffs.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'periods', 'services'));
    }

    private static function getPeriods(): array
    {
        return [null => 'Выберите период...'] + BillingTariff::$periods;
    }

    private static function getServices(): array
    {
        return [null => 'Выберите сервисы...'] +
            BillingService::query()->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $tariff = BillingTariff::query()->firstOrCreate(self::getData($inputData));

            self::syncServices($inputData, $tariff);

            session()->flash('success', __('admin.Record saved'));

            return redirect()->route('cms.billing.tariffs.index');
        }
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Название обязательно для заполнения',
            'description.required' => 'Описание обязательно',
        ]);
    }

    #[ArrayShape(['name' => "mixed", 'description' => "mixed", 'end_date' => "mixed"])]
    public static function getData($inputData): array
    {
        return [
            'name' => $inputData['name'],
            'description' => $inputData['description'],
            'end_date' => !empty($inputData['end_date']) ? $inputData['end_date'] : null
        ];
    }

    /**
     * @param $inputData
     * @param $tariff
     */
    public static function syncServices($inputData, $tariff): void
    {
        $services = $inputData['services'] ?? [];
        if (!empty($services)) {
            $services = array_filter($inputData['services']);
            $tariff->services()->sync($services);
        }
    }

    public function index()
    {
        $title = __('admin.tariffs');

        $breadcrumbs = $this->breadcrumbs;

        $tariffs = BillingTariff::query();

        $fields = $tariffs = $this->setFields($tariffs);

        $filter = new CmsFilter(BillingTariff::class, 'cms.billing.tariffs.index');

        $filter->addField('name', 'Название')
            ->addField('description', 'Описание')
            ->addButton('Создать', 'cms.billing.tariffs.create');

        $filter = $filter->render();

        return view('cms.tariffs.index',
            compact('fields', 'title', 'tariffs', 'filter', 'breadcrumbs'));
    }

    public function edit($tariffId)
    {
        $title = 'Редактирование';
        $form = BillingTariff::findOrFail($tariffId);
        $action = 'cms.billing.tariffs.update';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;

        $periods = self::getPeriods();
        $services = self::getServices();

        return view('cms.tariffs.edit',
            compact('title', 'breadcrumbs', 'form', 'action', 'periods', 'services'));
    }

    public function update(Request $request, $tariffId)
    {
        $tariff = BillingTariff::query()->findOrFail($tariffId);
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $tariff->update(self::getData($inputData));

            self::syncServices($inputData, $tariff);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('cms.billing.tariffs.index');
        }
    }

    public function delete($tariffId)
    {
        $tariff = BillingTariff::findOrFail($tariffId);

        try {
            $tariff->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Невозможно удалить запись');
        }

        session()->flash('success', 'Запись удалена');

        return redirect()->route('cms.billing.tariffs.index');
    }
}