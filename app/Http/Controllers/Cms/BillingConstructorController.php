<?php

namespace App\Http\Controllers\Cms;

use App\Models\BillingService;
use App\Models\BillingServiceTariff;
use App\Models\BillingTariff;
use App\Utils\CmsFilter;
use Illuminate\Http\Request;
use Validator;

class BillingConstructorController extends CmsController
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Конструктор тарифов', 'cms.billing.constructor.index'];
    }

    public function show()
    {

    }

    public function create()
    {
        $check = self::checkAll();

        if ($check) {
            return $check;
        }

        $title = __('admin.add');
        $breadcrumbs = $this->breadcrumbs;

        $tariffs = BillingTariff::query()->orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
        $services = BillingService::query()->orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
        $filter = new CmsFilter(BillingService::class, 'cms.billing.constructor.index');

        $filter->addButton('Создать', 'cms.billing.services.create');

        $filter = $filter->render();
        $action = 'cms.billing.constructor.store';
        $form = new BillingServiceTariff();

        return view('cms.billing_constructor.new_form',
            compact('form', 'fields', 'title', 'services', 'filter', 'breadcrumbs', 'tariffs', 'title', 'action'));

    }

    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            unset($inputData['_token'], $inputData['name']);

            BillingServiceTariff::firstOrCreate($inputData);

            session()->flash('success', __('admin.Record saved'));

            return redirect()->route('cms.billing.constructor.index');
        }
    }


    public function index()
    {

        $check = self::checkAll();

        if ($check) {
            return $check;
        }

        $title = 'Конструктор тарифов';

        $breadcrumbs = $this->breadcrumbs;

        $tariffs = BillingServiceTariff::query();

        $fields = $this->setFields($tariffs);

        $filter = new CmsFilter(BillingServiceTariff::class, 'cms.billing.constructor.index');

        $filter->addButton('Создать', 'cms.billing.constructor.create');

        $filter = $filter->render();

        return view('cms.billing_constructor.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }


    public function edit($tariffId)
    {
        $title = 'Редактирование';
        $form = BillingServiceTariff::findOrFail($tariffId);
        $action = 'cms.billing.constructor.update';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $services = BillingService::query()->orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
        $tariffs = BillingTariff::query()->orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();

        return view('cms.billing_constructor.edit',
            compact('title', 'breadcrumbs', 'form', 'action', 'services', 'tariffs'));
    }

    public function update(Request $request, $tariffId)
    {
        $billingService = BillingServiceTariff::findOrFail($tariffId);

        $data = $request->all();

        $billingService->update($data);

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('cms.billing.constructor.index');
    }

    public function delete($tariffId)
    {
        $billingService = BillingServiceTariff::find($tariffId);

        if ($billingService) {
            $billingService->delete();
        }

        return redirect()->route('cms.billing.constructor.index');
    }

    public static function checkAll()
    {
        if (count(BillingTariff::all()) == 0) {
            session()->flash('error', 'Сначала создайте тариф');
            return redirect(route('cms.billing.tariffs.index'));
        }

        if (count(BillingService::all()) == 0) {
            session()->flash('error', 'Сначала создайте сервис для тарифа');
            return redirect(route('cms.billing.services.index'));
        }

        return null;
    }

    public static function getValidator($data)
    {
        $errors = [
            'billing_service_id' => 'required',
            'billing_tariff_id' => 'required'
        ];

        $messages = [
            'description.required' => 'Описание обязательно',
            'price.required' => 'Цена обязательна для заполнения',
            'period.required' => 'Период действия услуги не выбран',
            'billing_service_id.required' => 'Вы не выбрали сервис',
            'billing_tariff_id.required' => 'Вы не выбрали тариф',
        ];

        return Validator::make($data, $errors, $messages);
    }
}