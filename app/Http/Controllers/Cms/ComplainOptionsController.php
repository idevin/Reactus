<?php

namespace App\Http\Controllers\Cms;

use App\Models\ComplainOption;
use App\Models\Permission;
use App\Models\SectionRole;
use App\Models\SectionUser;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use Illuminate\Http\Request;
use App\Utils\CmsFilter;
use App\Http\Requests;
use Illuminate\Http\Response;
use Validator;

class ComplainOptionsController extends CmsController
{

    use DomainTrait;
    use Site;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Опции жалоб', 'complain_options.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = 'Опции';

        $root = ComplainOption::root();

        if (!$root) {
            ComplainOption::create(['title' => 'Список опций жалоб']);
            $root = ComplainOption::root();
        }

        $breadcrumbs = $this->breadcrumbs;

        $complainOptions = ComplainOption::query();

        $fields = $this->setFields($complainOptions);

        $filter = new CmsFilter(ComplainOption::class, 'complain_options.index');

        $filter->addField('title', 'Название')
            ->addButton('Создать', 'complain_options.create');

        $filter = $filter->render();

        $request = request()->all();

        $order = null;
        if (isset($request['ord'])) {
            $order = true;
        }
        $treeData = ComplainOption::find($root->id)
            ->getDescendants()->toHierarchy();

        return view('cms.complain_options.index',
            compact('fields', 'title', 'filter', 'breadcrumbs', 'root', 'order', 'complainOptions', 'treeData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $title = 'Создать';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $form = new ComplainOption();
        $action = 'complain_options.store';
        $treeOptions = $complainOptions = ComplainOption::getTreeOptions();

        return view('cms.complain_options.new_form', compact('form', 'title', 'breadcrumbs', 'action', 'treeOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $inputData = $request->all();

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            $inputData['parent_id'] = $inputData['parent'];

            unset($inputData['_token'], $inputData['parent']);

            ComplainOption::firstOrCreate($inputData);

            session()->flash('success', 'Запись сохранена');

            return redirect()->route('complain_options.index');
        }
    }

    public function updateTree(Request $request)
    {
        parent::saveTree($request, ComplainOption::class);
        session()->flash('success', 'Запись сохранена');
        return redirect()->route('complain_options.index');
    }

    public static function getValidator($data)
    {
        $rules = [
            'title' => 'required',
            'value' => 'required'
        ];

        $messages = [
            'title.required' => 'Напишите название',
            'value.required' => 'Напишите значение для кармы'
        ];

        return Validator::make($data, $rules, $messages);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $title = 'Редактирование права';
        $form = ComplainOption::findOrFail($id);

        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'complain_options.update';
        $treeOptions = $complainOptions = ComplainOption::getTreeOptions();

        return view('cms.complain_options.edit',
            compact('form', 'title', 'breadcrumbs', 'action', 'treeOptions'));
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
        $field = ComplainOption::findOrFail($id);
        $inputData = $request->all();
        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {
            $field->update($inputData);
            session()->flash('success', 'Запись сохранена');
            return redirect()->route('complain_options.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        ComplainOption::find($id)->delete();

        session()->flash('success', 'Запись удалена!');

        return redirect()->route('complain_options.index');
    }
}
