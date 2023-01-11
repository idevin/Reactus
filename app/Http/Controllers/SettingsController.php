<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Site;
use App\Traits\Activity;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity(Setting::class);
    }

    public function site(): View|Factory|JsonResponse|bool|string|Redirector|Application|RedirectResponse
    {
        $result = $this->checkUserPolicy();

        if ($result !== true) {
            return $result;
        }

        $site = $this->getSite(env('DOMAIN'));
        $articlesSortOptions = Article::$sortOptions;
        $sectionsSortOptions = Section::$sortOptions;
        $articlesViewOptions = Article::$viewOptions;
        $sectionsViewOptions = Section::$viewOptions;

        \Breadcrumbs::register('site.settings', function ($breadcrumbs) {
            $breadcrumbs->parent('home');

            $breadcrumbs->push('Настройки');
        });

        return view(theme('settings.site'), compact('site', 'articlesSortOptions', 'sectionsSortOptions', 'articlesViewOptions', 'sectionsViewOptions'));
    }

    public function checkUserPolicy(): JsonResponse|bool|string|Redirector|RedirectResponse|Application
    {
        if (Auth::guest()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user && !$user->can('site_edit', new Site())) {
            return $this->error('Вы не имеете прав для редактирования настроек...');
        }

        return true;
    }

    public function siteUpdate(Request $request): JsonResponse|bool|string|Redirector|RedirectResponse|Application
    {
        $result = $this->checkUserPolicy();

        if ($result !== true) {
            return $result;
        }

        $data = $request->all();
        $site = $this->getSite(env('DOMAIN'));

        if (!isset($data['filter_articles'])) {
            $data['filter_articles'] = 0;
        } else {
            $data['filter_articles'] = 1;
        }

        if (!isset($data['filter_sections'])) {
            $data['filter_sections'] = 0;
        } else {
            $data['filter_sections'] = 1;
        }

        $site->update($data);
        \Session::flash('notice', 'Настройки успешно сохранены');
        return redirect()->back();
    }

}
