<?php

namespace App\Http\Controllers\Cms;

use App\Models\BillingSubscriptionService;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Http\Request;
use Validator;

class SubscriptionsController extends CmsController
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[] = ['Подписки', 'subscriptions.index'];
    }

    public function show()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function index()
    {
        $title = __('admin.subscriptions');

        $breadcrumbs = $this->breadcrumbs;

        $subscriptions = BillingSubscriptionService::query()->withTrashed();

        $fields = $subscriptions = $this->setFields($subscriptions);

        $filter = new CmsFilter(BillingSubscriptionService::class, 'subscriptions.index');

        $filter->addField('name', 'Название')
            ->addField('description', 'Описание');

        $filter = $filter->render();

        return view('cms.subscriptions.index',
            compact('fields', 'title', 'subscriptions', 'filter', 'breadcrumbs'));
    }

    public function undelete($id)
    {
        $o = BillingSubscriptionService::withTrashed()->find($id);
        if ($o) {
            $o->restore();
        }

        return redirect()->route('subscriptions.index')->with('success', 'Подписка восстановлена!');
    }

    public function destroyForever($id)
    {
        $o = BillingSubscriptionService::withTrashed()->find($id);
        if ($o) {
            $o->forceDelete();
        }

        return redirect()->route('subscriptions.index')->with('success', 'Подписка полностью удалена!');
    }

    public function edit($id)
    {
        $title = 'Редактирование';
        $form = BillingSubscriptionService::findOrFail($id);
        $action = 'subscriptions.update';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;

        return view('cms.subscriptions.edit',
            compact('title', 'breadcrumbs', 'form', 'action'));
    }

    public function update(Request $request, $id)
    {
        /** @var BillingSubscriptionService $o */
        $o = BillingSubscriptionService::query()->findOrFail($id);

        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        }
        $serviceData = [
            'created_at' => $inputData['created_at'],
            'ends_at' => $inputData['ends_at'],
            'next_write_off' => $inputData['next_write_off'],
            'pay_once' => isset($inputData['autorenew']) ? 1 : 0,
        ];

        $o->update($serviceData);

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('subscriptions.index');
    }

    public static function getValidator($data)
    {
        $errors = [
            'created_at' => 'required|date|date_format:Y-m-d H:i',
            'ends_at' => 'required|date|date_format:Y-m-d H:i',
            'next_write_off' => 'required|date|date_format:Y-m-d H:i',
        ];

        $messages = [
            'created_at.required' => 'Дата начала обязательна для заполнения',
            'ends_at.required' => 'Выберите дату окончания периода',
            'next_write_off.date' => 'Неправильная дата следующего списания',
            'billing_tariff_id.required' => 'Выберите тариф',
            'billing_discount_id.required' => 'Выберите скидку',
            'created_at.date_format' => 'Дата начала должна быть в виде 2970-12-31 00:10',
            'ends_at.date_format' => 'Дата начала должна быть в виде 2970-12-31 00:10',
            'next_write_off.date_format' => 'Дата начала должна быть в виде 2970-12-31 00:10'
        ];

        return Validator::make($data, $errors, $messages);
    }

    public function destroy($subscriptionId)
    {
        $tariff = BillingSubscriptionService::findOrFail($subscriptionId);

        try {
            $tariff->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Невозможно удалить запись');
        }

        session()->flash('success', 'Запись удалена');

        return redirect()->route('subscriptions.index');
    }
}