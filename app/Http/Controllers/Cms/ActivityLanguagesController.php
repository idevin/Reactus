<?php

namespace App\Http\Controllers\Cms;

use App\Models\Activity;
use App\Models\ActivityLanguage;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Media;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Lang;

class ActivityLanguagesController extends CmsController
{
    use DomainTrait;
    use Media;
    use CustomValidators;

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['сообщения логов', 'activity_languages.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->syncActivities();

        $title = 'Сообщения';

        $breadcrumbs = $this->breadcrumbs;

        $activities = ActivityLanguage::query()
            ->where('activity_key', 'LIKE', '%activity.title%')
            ->whereLang(Lang::getLocale());

        $fields = $this->setFields($activities);
        $filter = null;

        return view('cms.activity_languages.index',
            compact('fields', 'title', 'filter', 'breadcrumbs'));
    }

    public function syncActivities()
    {
        $activities = Activity::query()->whereNotNull('title')
            ->groupBy(['title'])->get();

        $languages = config('languages.default');

        foreach ($activities as $activity) {
            if (!empty($activity->title)) {
                preg_match('/\./', $activity->title, $matchesTitle);
                preg_match('/\./', $activity->description, $matchesDesc);

                if (!empty($matchesTitle)) {
                    $al = ActivityLanguage::query()->groupBy(['activity_key'])
                        ->whereActivityKey($activity->title)->first();

                    if (!$al) {
                        foreach ($languages as $langPrefix) {
                            $translated = __($activity->title, [], $langPrefix);
                            ActivityLanguage::firstOrCreate([
                                'activity_key' => $activity->title,
                                'lang' => $langPrefix,
                                'translated' => $translated != $activity->title ? $translated : null
                            ]);
                        }
                    }
                }

                if (!empty($matchesDesc)) {
                    $ald = ActivityLanguage::query()->groupBy(['activity_key'])
                        ->whereActivityKey($activity->description)->first();

                    if (!$ald) {
                        foreach ($languages as $langPrefix) {
                            $translated = __($activity->description, [], $langPrefix);
                            ActivityLanguage::firstOrCreate([
                                'activity_key' => $activity->description,
                                'lang' => $langPrefix,
                                'translated' => $translated != $activity->description ? $translated : null
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $title = 'Активность';
        $this->breadcrumbs[] = ['активность', 'activity_languages.index'];
        $breadcrumbs = $this->breadcrumbs;

        $item = Activity::find($id);

        if (!$item) {
            return redirect(route('activity_languages.index'))->withErrors('Лог не найден');
        }

        return view('cms.activity_languages.show', compact('breadcrumbs', 'title', 'item'));
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $title = 'Редактирование';
        $form = ActivityLanguage::findOrFail($id);
        $action = 'activity_languages.update';

        $this->breadcrumbs[] = [$title];
        $breadcrumbs = $this->breadcrumbs;
        $parsedActivity = preg_split('/\./', $form->activity_key);

        $str = function ($key) use ($parsedActivity) {
            return 'activity.' . $key . '.' . $parsedActivity[count($parsedActivity) - 2] . '.' .
                $parsedActivity[count($parsedActivity) - 1];
        };

        $descriptions = self::getDescriptions($str('description'));

        $titles = self::getDescriptions($str('title'));

        return view('cms.activity_languages.edit',
            compact('title', 'breadcrumbs', 'form', 'action', 'descriptions', 'titles'));
    }

    public static function getDescriptions($activityStr): array
    {
        $linkedDescriptions = ActivityLanguage::query()->where('activity_key', 'LIKE', '%' . $activityStr . '%')
            ->get()->keyBy('lang');

        $strings = [];

        foreach (config('languages.default') as $prefix) {
            $strings[$prefix] = $linkedDescriptions[$prefix];
        }

        return $strings;
    }

    public function update(Request $request, $id = null)
    {
        $data = $request->all();
        $allData = $data['description'] + $data['title'];

        if (!empty($allData)) {
            foreach ($allData as $id => $titles) {
                $activityObject = ActivityLanguage::query()->find($id);
                $activityObject->update([
                    'translated' => $titles[$activityObject->lang]
                ]);
            }
        }

        session()->flash('success', 'Записи обновлены!');

        return redirect()->route('activity_languages.index');
    }
}
