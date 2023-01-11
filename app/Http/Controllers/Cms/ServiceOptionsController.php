<?php

namespace App\Http\Controllers\Cms;

use App\Models\BillingDiscount;
use App\Models\BillingService;
use App\Models\BillingServiceOptions;
use App\Models\Role;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Http\Request;
use Validator;

class ServiceOptionsController extends CmsController
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Опции сервисов', 'cms.billing.service_options.index'];
    }

    public function show()
    {

    }

    public function create()
    {
        $title = __('admin.add');
        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new BillingServiceOptions();
        $action = 'cms.billing.service_options.store';
        $services = BillingService::query()->orderBy('name', 'asc')->get()->pluck('name', 'id');
        $types = BillingServiceOptions::$types;

        $session = request()->getSession()->all();
        $oldInput = isset($session['_old_input']) ? $session['_old_input'] : null;

        return view('cms.service_options.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'services', 'oldInput', 'types'));
    }

    public function store(Request $request)
    {
        $result = static::getValidator($request->all());

        if(!is_array($result)) {
            return $result;
        }

        BillingServiceOptions::query()->firstOrCreate($result);

        session()->flash('success', __('admin.Record saved'));

        return redirect()->route('cms.billing.service_options.index');
    }

    public function index()
    {
        $title = __('admin.services');

        $breadcrumbs = $this->breadcrumbs;

        $services = BillingServiceOptions::query();

        $fields = $services = $this->setFields($services);

        $filter = new CmsFilter(BillingServiceOptions::class, 'cms.billing.service_options.index');

        $filter->addField('name', 'Название')->addButton('Создать', 'cms.billing.service_options.create');

        $filter = $filter->render();

        return view('cms.service_options.index',
            compact('fields', 'title', 'services', 'filter', 'breadcrumbs'));
    }


    public function edit($serviceId)
    {
        $title = 'Редактирование';
        $form = BillingServiceOptions::findOrFail($serviceId);
        $action = 'cms.billing.service_options.update';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $services = BillingService::query()->orderBy('name', 'asc')->get()->pluck('name', 'id');
        $types = BillingServiceOptions::$types;

        return view('cms.service_options.edit',
            compact('title', 'breadcrumbs', 'services', 'form', 'action', 'types'));
    }

    public function update(Request $request, $serviceId)
    {
        $service = BillingServiceOptions::findOrFail($serviceId);

        $result = static::getValidator($request->all());

        if(!is_array($result)) {
            return $result;
        }

        $service->update($result);

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('cms.billing.service_options.index');
    }

    public function delete($tariffId)
    {
        $serviceOption = BillingServiceOptions::findOrFail($tariffId);

        try {
            $serviceOption->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Невозможно удалить запись');
        }

        session()->flash('success', 'Запись удалена');

        return redirect()->route('cms.billing.service_options.index');
    }

    public static function getValidator($data)
    {
        $errors = [
            'name' => 'required',
            'increment_type' => 'required',
            'price' => 'required',
            'billing_service_id' => 'required'
        ];

        $messages = [
            'name.required' => 'Название обязательно для заполнения',
            'increment_type.required' => 'Не заполнен тип опции',
            'billing_service_id.required' => 'Вы не выбрали сервис',
            'price.required' => 'Напишите цену'
        ];

        $validator = Validator::make($data, $errors, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput($data)->withErrors($validator);
        }

        return [
            'name' => $data['name'],
            'billing_service_id' => $data['billing_service_id'],
            'price' => $data['price'],
            'increment_type' => $data['increment_type']
        ];
    }
}