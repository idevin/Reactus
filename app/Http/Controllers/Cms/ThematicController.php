<?php

namespace App\Http\Controllers\Cms;

use App\Models\Domain;
use App\Models\DomainThematic;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Traits\Utils;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Validator;

class ThematicController extends CmsController
{
    use DomainTrait;
    use Site;
    use CustomValidators;
    use Utils;


    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Тематика доменов', 'thematic.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $title = 'Тематика доменов';

        $filter = new CmsFilter(DomainThematic::class, 'thematic.index');
        $filter = $filter->addField('name', 'Название')
            ->addButton('Создать', 'thematic.create')->render();

        $domain = DomainThematic::query();

        $breadcrumbs = $this->breadcrumbs;
        $fields = $this->setFields($domain);

        return view('cms.thematic.index', compact('filter', 'title', 'breadcrumbs', 'fields'));
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
        $form = new DomainThematic();
        $action = 'thematic.store';

        return view('cms.thematic.new_form', compact('form', 'title', 'breadcrumbs', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        $thematicName = $inputData['name'];

        $validator = static::getValidator($inputData, true);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            DomainThematic::firstOrCreate([
                'name' => $thematicName
            ]);
        }

        session()->flash('success', 'Запись сохранена');
        return redirect()->route('thematic.index');
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
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $title = 'Редактирование тематики';

        $form = DomainThematic::find($id);
        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'thematic.update';
        return view('cms.thematic.edit', compact('form', 'title', 'breadcrumbs', 'action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $inputData = $request->all();
        $domainThematic = DomainThematic::find($id);
        $inputData['update'] = true;

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $domainThematic->update([
                'name' => $inputData['name'],
            ]);
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('thematic.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     * @throws Exception
     * @throws Exception
     */
    public function destroy($id)
    {
        $domainThematic = DomainThematic::find($id);
        $domain = Domain::where('domain_thematic_id', $domainThematic->id)->first();

        if ($domain && $domain->site) {
            return redirect()
                ->route('thematic.index')
                ->with('error', 'Нельзя удалить тематику так как есть созданный сайт!');
        }

        $domainThematic->delete();

        session()->flash('success', 'Запись удалена');

        return redirect()->route('thematic.index');
    }

    /**
     * @param $data
     * @param null $unique
     * @return \Illuminate\Validation\Validator
     */
    public static function getValidator($data, $unique = null)
    {
        $rules = [
            'name' => 'required'
        ];

        if ($unique) {
            $rules['name'] .= '|unique:domain_thematic,name';
        }

        $messages = [
            'name.unique' => 'Такое название уже есть',
            'name.requied' => 'Напишите название тематики',
        ];

        return Validator::make($data, $rules, $messages);
    }
}
