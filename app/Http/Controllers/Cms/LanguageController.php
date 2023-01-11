<?php

namespace App\Http\Controllers\Cms;

use App\Models\Language;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Traits\Utils;
use App\Utils\CmsFilter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class LanguageController extends CmsController
{
    use DomainTrait;
    use Site;
    use CustomValidators;
    use Utils;


    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Языки', 'thematic.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = 'Языки';

        $filter = new CmsFilter(Language::class, 'language.index');
        $filter = $filter->addField('name', 'Название')
            ->addButton('Создать', 'language.create')->render();

        $domain = Language::query();

        $breadcrumbs = $this->breadcrumbs;
        $fields = $this->setFields($domain);

        return view('cms.language.index', compact('filter', 'title', 'breadcrumbs', 'fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = 'Новая тематика';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Language();
        $action = 'language.store';

        return view('cms.language.new_form', compact('form', 'title', 'breadcrumbs', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return RedirectResponse|Response
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData, null);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            Language::firstOrCreate([
                'title' => $inputData['title'],
                'alias' => $inputData['alias'],
                'priority' => $inputData['priority']
            ]);
        }

        session()->flash('success', 'Запись сохранена');
        return redirect()->route('language.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $title = 'Редактирование языка';

        $form = Language::query()->find($id);
        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'language.update';
        return view('cms.language.edit', compact('form', 'title', 'breadcrumbs', 'action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $inputData = $request->all();
        $language = Language::find($id);

        $validator = static::getValidator($inputData, $language);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $language->update([
                'title' => $inputData['title'],
                'alias' => $inputData['alias'],
                'priority' => (int)$inputData['priority']
            ]);
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('language.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $language = Language::find($id);
        $language->delete();

        session()->flash('success', 'Запись удалена');

        return redirect()->route('language.index');
    }

    public static function getValidator($data, $thematic)
    {
        $rules = [
            'title' => 'required',
            'alias' => 'required'
        ];

        if ($thematic) {
        }

        $messages = [
            'title.required' => 'Напишите название',
            'alias.requied' => 'Напишите псеводним',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
