<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Site;
use App\Traits\Activity;
use Symfony\Component\HttpFoundation\Request;

class TrashBinController extends Controller
{
    use Activity;

    public static $allowedTypes = ['article', 'section'];

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity();
    }

    public function showBySection(Request $request, $sectionName, $id)
    {
        return $this->show($request, $id);
    }

    public function show(Request $request, $sectionName, $id = null)
    {
        if (!\Auth::user()) {
            return redirect('/');
        }

        if (!$id) {
            return $this->error('Неверный ID');
        }

        $site = get_site();
        $section = Section::query()->bySite($site->id)->find($id);

        if (!$section) {
            return $this->error('Раздел не найден');
        }

        if (\Auth::user() && !\Auth::user()->can('trash_access', new Section())) {
            return $this->error('Вы не можете просматривать корзину');
        }

        $ssr = self::ssr();

        return view(session('theme'), compact('ssr'));
    }
}