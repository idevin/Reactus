<?php

namespace App\Http\Controllers\Cms;

use App\Models\Feedback;
use App\Models\Field;
use App\Models\Site as SiteModel;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class FeedbackController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Обратная связь', 'feedback.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $title = 'Формы для обратной связи';

        $filter = Feedback::query()->with(['site', 'field']);

        $fields = $filter->get();
        $fieldsArray = [];

        foreach ($fields as $index => $field) {
            $currentIndex = $field->site_id;

            if (!$currentIndex) {
                $currentIndex = $index;
            }

            if (isset($field->field)) {
                $fieldsArray[$currentIndex]['site'] = $field->site;
                $fieldsArray[$currentIndex][$field->field->field_group_id]['group'] = $field->field->field_group;
                $fieldsArray[$currentIndex][$field->field->field_group_id]['fields'][] = $field;
            }
        }

        $filter = new CmsFilter(Feedback::class, 'feedback.index');

        $filter->addField('site::domain', 'Сайт')
            ->addButton('Создать', 'feedback.create');

        $filter = $filter->render();

        $breadcrumbs = $this->breadcrumbs;

        return view('cms.feedback.index', compact('fields', 'filter', 'title', 'breadcrumbs', 'fieldsArray'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function create(Request $request): Factory|View|Application
    {
        $title = 'Добавить';
        $fieldGroups = [];
        $this->breadcrumbs[] = ['Создание поля'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Field();
        $action = 'feedback.store';
        $sites = \App\Models\Site::getTreeOptions(null, true, true);
        $feedbackFields = null;

        $siteId = $request->get('site_id');

        if (!empty($siteId)) {
            $site = SiteModel::whereId($request->get('site_id'))->first();

            if ($site) {

                $siteFields = Field::with(['field_group'])->get();

                $feedbackFields = Feedback::whereSiteId($site->id)->get();

                if (count($siteFields) > 0) {
                    foreach ($siteFields as $field) {
                        if (count($feedbackFields) > 0) {
                            foreach ($feedbackFields as $feedbackField) {
                                if ($feedbackField->field_id == $field->id) {
                                    $field->checked = true;
                                }
                            }
                        }

                        $fieldGroups[$field->field_group_id]['group'] = $field->field_group;
                        $fieldGroups[$field->field_group_id]['fields'][] = $field;
                    }
                }
            }
        }

        Feedback::flushCache();

        return view('cms.feedback.new_form',
            compact('form', 'title', 'breadcrumbs', 'action', 'sites', 'fieldGroups', 'feedbackFields', 'siteId'));

    }

    /**
     * Store a newly created resource in storage.
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
            Feedback::query()->where('site_id', $inputData['site_id'])->delete();

            foreach ($inputData['field_id'] as $field) {
                Feedback::query()->create([
                    'field_id' => $field,
                    'site_id' => $inputData['site_id']
                ]);
            }

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('feedback.index');
        }
    }

    public static function getValidator($data)
    {
        return Validator::make($data, [
            'site_id' => 'required',
            'field_id' => 'required'
        ], [
            'site_id.required' => 'Сайт не выбран',
            'field_id.required' => 'Не выбраны поля'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(Request $request, $id)
    {
        $title = 'Поля для обратной связи';

        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'feedback.update';
        $sites = \App\Models\Site::getTreeOptions(null, true, false);
        $fieldGroups = [];

        $request->query->set('site_id', $id);

        $form = SiteModel::where(['id' => $id])->get()->first();

        $siteId = $request->get('site_id');

        if ($form) {

            $siteFields = Field::with(['field_group'])->get();
            $arMappedSiteFields = [];
            foreach ($siteFields as $obSiteField) {
                $arMappedSiteFields[$obSiteField->id] = $obSiteField;
            }

            $feedbackFields = Feedback::sorted()->where('site_id', $form->id)->get();

            if (count($arMappedSiteFields) > 0) {
                /** @var Field $field */
                foreach ($arMappedSiteFields as $field) {
                    if (count($feedbackFields) > 0) {
                        /** @var Feedback $feedbackField */
                        foreach ($feedbackFields as $feedbackField) {
                            if ($feedbackField->field_id == $field->id) {
                                $field->checked = true;
                                $field->sort_order = $feedbackField->sort_order;
                            }
                        }
                    }

                    $fieldGroups[$field->field_group_id]['group'] = $field->field_group;
                    $fieldGroups[$field->field_group_id]['fields'][] = $field;
                    usort($fieldGroups[$field->field_group_id]['fields'], function ($obFirstField, $obSecondField) {
                        if (!isset($obFirstField->sort_order) || !isset($obSecondField->sort_order)) {
                            return 0;
                        }

                        $a = $obFirstField->sort_order;
                        $b = $obSecondField->sort_order;
                        if ($a == $b) {
                            return 0;
                        }

                        return ($a < $b) ? -1 : 1;
                    });
                }
            }
        }

        return view('cms.feedback.edit', compact('form', 'title', 'breadcrumbs', 'action', 'sites', 'fieldGroups', 'siteId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function update(Request $request, $id)
    {
        $site = SiteModel::find($request->get('site_id'));
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            Feedback::where('site_id', $site->id)->delete();

            foreach ($inputData['field_id'] as $field) {
                Feedback::create([
                    'field_id' => $field,
                    'site_id' => $site->id,
                    'sort_order' => (isset($inputData['field_sort']) && isset($inputData['field_sort'][$field])) ? $inputData['field_sort'][$field] : null,
                ]);
            }

            Feedback::flushCache();

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('feedback.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function destroy($id)
    {
        $site = SiteModel::findOrFail($id);

        Feedback::where('site_id', $site->id)->delete();

        session()->flash('success', 'Данные удалены!');

        return redirect()->route('feedback.index');
    }
}
