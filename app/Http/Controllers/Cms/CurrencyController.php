<?php

namespace App\Http\Controllers\Cms;

use App\Models\Activity;
use App\Models\Currency;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use App\Traits\Utils;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Validator;

class CurrencyController extends CmsController
{
    use DomainTrait;
    use Media;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['валюта', 'currency.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $title = 'Валюта';

        $breadcrumbs = $this->breadcrumbs;

        $activities = Currency::query();

        $fields = $this->setFields($activities);

        $filter = new CmsFilter(Activity::class, 'currency.index');

        $filter->addField('name', 'Название')
            ->addButton('Создать', 'currency.create');

        $filter = $filter->render();

        return view('cms.currency.index', compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    public function create()
    {
        $title = 'Создать';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Currency();
        $action = route('currency.store');

        $codes = Currency::currencySelect();

        return view('cms.currency.new_form', compact('form', 'title', 'breadcrumbs', 'action', 'codes'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = static::getValidator($data);

        if ($validator->fails()) {
            return redirect()->back()->withInput($data)->withErrors($validator);
        } else {

            $data = self::currencies($data);

            Currency::firstOrCreate(self::getData($data));

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('currency.index');
        }
    }

    public static function getValidator(&$data, $except = [], $customErrors = [], $customMessages = [])
    {
        $default = [
            'name' => 'required',
            'iso_code' => 'required',
            'points_value' => 'required',
            'currency_value' => 'required'
        ];

        $messages = [
            'name.required' => 'Имя',
            'iso_code.required' => 'Выберите ISO код',
            'currency_value.required' => 'Значение в валюте',
            'points_value.required' => 'Напишите значение в поинтах'
        ];

        return Utils::makeValidator($data, $messages, $customMessages, $default, $customErrors, $except);
    }

    public static function currencies($data)
    {
        $codes = Currency::currencies();

        foreach (collect($codes)->pluck('currencies', 'numericCode') as $iso4217Code => $currencies) {
            foreach ($currencies as $item) {
                if (!empty($item['code']) && $item['code'] == $data['iso_code']) {
                    $data['iso4217_code'] = $iso4217Code;
                    $data['sign'] = $item['symbol'];
                    break;
                }
            }
        }

        unset($data['_token']);

        return $data;
    }

    private static function getData($inputData)
    {
        return [
            "iso4217_code" => $inputData['iso4217_code'],
            'iso_code' => $inputData['iso_code'],
            "name" => $inputData['name'],
            "points_value" => $inputData['points_value'],
            "currency_value" => $inputData['currency_value'],
            "sign" => $inputData['sign'],
            "is_default" => isset($inputData['is_default']) ? $inputData['is_default'] : 0
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show(int $id)
    {
        $title = 'Валюта';
        $this->breadcrumbs[] = ['Валюта', 'currency.index'];
        $breadcrumbs = $this->breadcrumbs;

        $item = Activity::find($id);

        if (!$item) {
            return redirect(route('currency.index'))->withErrors('Лог не найден');
        }

        return view('cms.currency.show', compact('breadcrumbs', 'title', 'item'));
    }

    public function edit($id)
    {
        $title = 'Редактирование Валюты';
        $form = Currency::findOrfail($id);

        $action = route('currency.update', ['currency' => $form->id]);
        $this->breadcrumbs[] = ['Редактирование меню'];
        $breadcrumbs = $this->breadcrumbs;
        $codes = Currency::currencySelect();
        return view('cms.currency.edit', compact('title', 'breadcrumbs', 'action', 'form', 'codes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $currency = Currency::query()->findOrFail($id);
        $data = $request->all();
        $validator = self::getValidator($data);

        if ($validator->fails()) {
            return redirect()->back()->withInput($data)->withErrors($validator);
        } else {

            $data = self::currencies($data);

            $currency->update(self::getData($data));
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('currency.index');
    }

    public function destroy($id)
    {
        /** @var TYPE_NAME $currency */
        $currency = Currency::findOrFail($id);

        try {
            $currency->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Невозможно удалить запись');
        }

        session()->flash('success', 'Запись удалена');

        return redirect()->route('currency.index');
    }
}
