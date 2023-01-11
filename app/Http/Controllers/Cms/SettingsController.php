<?php

namespace App\Http\Controllers\Cms;

use App\Models\Setting;
use App\Models\Site as SiteModel;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\ArrayShape;
use Validator;

class SettingsController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Настройки для сайта', 'settings.index'];

    }

    /**
     * Display a listing of the resource.
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $title = 'Настройки';

        $breadcrumbs = $this->breadcrumbs;

        $roles = Setting::with(['site']);

        $fields = $this->setFields($roles);

        $filter = new CmsFilter(Setting::class, 'settings.index');

        $filter->addButton('Создать', 'settings.create');

        $filter = $filter->render();

        return view('cms.settings.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View|Application
     * @internal param Request $request
     */
    public function create(): Factory|View|Application
    {
        $title = 'Создать';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Setting();
        $action = 'settings.store';
        $sites = SiteModel::getTreeOptions(null, true);

        return view('cms.settings.new_form', compact('form', 'title', 'breadcrumbs', 'action', 'sites'));
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            Setting::query()->create(self::getData($inputData));

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('settings.index');
        }
    }

    public static function getValidator($data, $withSite = true)
    {
        $rules = [
            'site_id' => 'required|unique:settings,site_id',
        ];

        if ($withSite == false) {
            $rules['site_id'] = 'required';
        }

        $messages = [
            'site_id.required' => 'Выберите сайт',
        ];

        return Validator::make($data, $rules, $messages);
    }

    #[ArrayShape(['site_id' => "mixed", 'google_code' => "mixed", 'yandex_code' => "mixed",
        'yandex_verification' => "mixed", 'google_verification' => "mixed", 'google_tag' => "mixed"])]
    public static function getData($inputData): array
    {
        return [
            'site_id' => $inputData['site_id'],
            'google_code' => $inputData['google_code'],
            'yandex_code' => $inputData['yandex_code'],
            'yandex_verification' => $inputData['yandex_verification'],
            'google_verification' => $inputData['google_verification'],
            'google_tag' => $inputData['google_tag']
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View|Application
     */
    public function edit(int $id): Factory|View|Application
    {
        $title = 'Редактирование';

        $form = Setting::query()->findOrFail($id);

        $this->breadcrumbs[] = ['Редактирование настроек'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'settings.update';

        $sites = SiteModel::getTreeOptions(null, true);

        return view('cms.settings.edit', compact('form', 'title', 'breadcrumbs', 'action', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $setting = Setting::query()->find($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData, false);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $setting->update(self::getData($inputData));

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('settings.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $setting = Setting::query()->find($id);
        $setting->delete();

        session()->flash('success', 'Настройки удалены!');

        return redirect()->route('settings.index');
    }
}
