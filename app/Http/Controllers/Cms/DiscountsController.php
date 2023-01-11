<?php

namespace App\Http\Controllers\Cms;

use App\Models\BillingDiscount;
use App\Models\Currency;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Http\Request;
use Validator;

class DiscountsController extends CmsController
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Скидки для тарифов', 'cms.billing.discounts.index'];
    }

    public function show()
    {

    }

    public function create()
    {
        $title = __('admin.add');
        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new BillingDiscount();
        $action = 'cms.billing.discounts.store';

        $session = request()->getSession()->all();
        $oldInput = isset($session['_old_input']) ? $session['_old_input'] : null;
        $codes = [null => 'Выберите валюту...'] +
            Currency::query()->orderBy('iso_code', 'asc')->get()->pluck('iso_code', 'id')->toArray();

        return view('cms.discounts.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'oldInput', 'codes'));
    }

    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $discountData = [
                'name' => $inputData['name'],
                'percent' => $inputData['percent'],
                'amount' => $inputData['amount'],
                'currency_id' => !empty($inputData['currency_id']) ? $inputData['currency_id'] : null
            ];

            BillingDiscount::firstOrCreate($discountData);

            session()->flash('success', __('admin.Record saved'));

            return redirect()->route('cms.billing.discounts.index');
        }
    }

    public function index()
    {
        $title = __('admin.discounts');

        $breadcrumbs = $this->breadcrumbs;

        $discounts = BillingDiscount::query()->with('currency');

        $fields = $discounts = $this->setFields($discounts);

        $filter = new CmsFilter(BillingDiscount::class, 'cms.billing.discounts.index');

        $filter->addField('name', 'Название')
            ->addField('description', 'Описание')
            ->addButton('Создать', 'cms.billing.discounts.create');

        $filter = $filter->render();

        return view('cms.discounts.index',
            compact('fields', 'title', 'discounts', 'filter', 'breadcrumbs'));
    }


    public function edit($serviceId)
    {
        $title = 'Редактирование';
        $form = BillingDiscount::findOrFail($serviceId);
        $action = 'cms.billing.discounts.update';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $codes = [null => 'Выберите валюту...'] +
            Currency::query()->orderBy('iso_code', 'asc')->get()->pluck('iso_code', 'id')->toArray();


        return view('cms.discounts.edit',
            compact('title', 'breadcrumbs', 'form', 'action', 'codes'));
    }

    public function update(Request $request, $serviceId)
    {
        $discount = BillingDiscount::findOrFail($serviceId);
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $discountData = [
                'name' => $inputData['name'],
                'amount' => $inputData['amount'],
                'percent' => $inputData['percent'],
                'currency_id' => !empty($inputData['currency_id']) ? $inputData['currency_id'] : null
            ];

            $discount->update($discountData);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('cms.billing.discounts.index');
        }
    }

    public function delete($tariffId)
    {
        $discount = BillingDiscount::findOrFail($tariffId);

        try {
            $discount->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Невозможно удалить запись');
        }

        session()->flash('success', 'Запись удалена');

        return redirect()->route('cms.billing.discounts.index');
    }

    public static function getValidator($data)
    {
        $errors = [
            'name' => 'required',
            'amount' => 'required',
            'percent' => 'required',
            'currency_id' => 'required'
        ];

        $messages = [
            'name.required' => 'Название обязательно для заполнения',
            'percent.required' => 'Заполните проценты',
            'amount.required' => 'Количество поинтов обязательно для заполнения',
            'currency_id.required' => 'Выберите валюту'
        ];

        return Validator::make($data, $errors, $messages);
    }
}