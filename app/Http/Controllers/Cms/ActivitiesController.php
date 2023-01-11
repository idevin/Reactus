<?php

namespace App\Http\Controllers\Cms;

use App\Models\Activity;
use App\Models\User;
use App\Traits\Activity as ActivityTrait;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use App\Utils\CmsFilter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ActivitiesController extends CmsController
{
    use DomainTrait;
    use Media;
    use CustomValidators;
    use ActivityTrait;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['активность', 'activities.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index(): Factory|Response|View|Application
    {
        $title = 'Активность';

        $breadcrumbs = $this->breadcrumbs;

        $activities = Activity::query()->with('user', 'site')->orderBy('created_at', 'desc');

        $fields = $this->setFields($activities, 50);

        $filter = new CmsFilter(Activity::class, 'activities.index');

        $filter->addField('site|site::domain', 'Сайт')
            ->addField('session_name', 'ID')
            ->addField('user|user::username,first_name,last_name', 'Пользователь')
            ->addField('created_at', 'Период');

        $filter = $filter->render();
        $grouped = collect($fields->items())->groupBy('session_name');
        $groupedArray = [];

        foreach ($grouped as $id => $group) {
            $groupedArray[$id]['sessions'] = $group;
            $names = [];

            foreach ($group as $i) {
                if ($i->user) {
                    $name = username($i->user);
                    $groupedArray[$id]['user'][$i->user->id] = $name;
                } else {
                    $name = 'Aноним';
                    $groupedArray[$id]['user'][-1] = $name;
                }
                $names[$name] = $name;
            }
        }

        $groupedArray = array_values($groupedArray);
        $grouped = $groupedArray;

        return view('cms.activities.index', compact('fields', 'title', 'filter', 'breadcrumbs', 'grouped'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $title = 'Активность';
        $this->breadcrumbs[] = ['активность', 'activities.index'];
        $breadcrumbs = $this->breadcrumbs;

        $item = Activity::find($id);

        if (!$item) {
            return redirect(route('activities.index'))->withErrors('Лог не найден');
        }

        return view('cms.activities.show', compact('breadcrumbs', 'title', 'item'));
    }
}
