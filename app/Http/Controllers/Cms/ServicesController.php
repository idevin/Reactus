<?php

namespace App\Http\Controllers\Cms;

use App\Models\BillingDiscount;
use App\Models\BillingService;
use App\Models\Role;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Validator;

class ServicesController extends CmsController
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Сервисы', 'cms.billing.services.index'];
    }

    public function show()
    {

    }

    public function create()
    {
        $title = __('admin.add');
        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new BillingService();
        $action = 'cms.billing.services.store';

        $roles = Role::query()->orderBy('name', 'asc')->with('permissions')->get();

        $discounts = BillingDiscount::query()->orderBy('name', 'asc')->get()->pluck('name', 'id');

        $session = request()->getSession()->all();
        $oldInput = isset($session['_old_input']) ? $session['_old_input'] : null;

        return view('cms.services.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'roles', 'oldInput', 'discounts'));
    }

    public function store(Request $request): RedirectResponse
    {

        $serviceData = self::getData($request);

        if (get_class($serviceData) === RedirectResponse::class) {
            return $serviceData;
        }

        /** @var BillingService $service */
        $service = BillingService::query()->firstOrCreate($serviceData);

        if (!empty($inputData['roles'])) {
            $service->roles()->sync($inputData['roles']);
        }

        session()->flash('success', __('admin.Record saved'));

        return redirect()->route('cms.billing.services.index');
    }

    public static function getData($request): array|RedirectResponse
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        }

        return [
            'name' => $inputData['name'],
            'description' => $inputData['description'],
            'pay_once' => isset($inputData['pay_once']) ? 1 : 0,
            'price' => $inputData['price'],
            'period' => $inputData['period'],
            'period_amount' => $inputData['period_amount'],
            'free_period' => $inputData['free_period'],
            'free_period_amount' => $inputData['free_period_amount']
        ];
    }

    public static function getValidator($data)
    {
        $errors = [
            'name' => 'required',
            'description' => 'required',
            'roles' => 'required|array',
            'period' => 'required',
            'period_amount' => 'required',
            'price' => 'required'
        ];

        $messages = [
            'name.required' => 'Название обязательно для заполнения',
            'description.required' => 'Описание обязательно',
            'roles.required' => 'Вы не выбрали права',
            'period.required' => 'Выберите период',
            'period_amount.required' => 'Выберите кол-во периода',
            'price.required' => 'Напишите цену',
            'roles.array' => 'Вы не выбрали права'

        ];

        return Validator::make($data, $errors, $messages);
    }

    public function index()
    {
        $title = __('admin.services');

        $breadcrumbs = $this->breadcrumbs;

        $services = BillingService::query();

        $fields = $services = $this->setFields($services);

        $filter = new CmsFilter(BillingService::class, 'cms.billing.services.index');

        $filter->addField('name', 'Название')
            ->addField('description', 'Описание')
            ->addButton('Создать', 'cms.billing.services.create');

        $filter = $filter->render();

        return view('cms.services.index',
            compact('fields', 'title', 'services', 'filter', 'breadcrumbs'));
    }

    public function edit($serviceId)
    {
        $title = 'Редактирование';
        $form = BillingService::findOrFail($serviceId);
        $action = 'cms.billing.services.update';
        $roleIds = $form->roles->pluck('id')->toArray();

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $roles = Role::query()->orderBy('name', 'asc')->with('permissions')->get();

        return view('cms.services.edit',
            compact('title', 'breadcrumbs', 'roles', 'form', 'action', 'roleIds'));
    }

    public function update(Request $request, $serviceId): RedirectResponse
    {
        /** @var BillingService $service */
        $service = BillingService::query()->findOrFail($serviceId);

        $serviceData = self::getData($request);

        if (get_class($serviceData) === RedirectResponse::class) {
            return $serviceData;
        }

        $service->update($serviceData);

        if (!empty($inputData['roles'])) {
            $service->roles()->sync($inputData['roles']);
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('cms.billing.services.index');
    }

    public function delete($tariffId): RedirectResponse
    {
        $tariff = BillingService::query()->findOrFail($tariffId);

        try {
            $tariff->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Невозможно удалить запись');
        }

        session()->flash('success', 'Запись удалена');

        return redirect()->route('cms.billing.services.index');
    }
}