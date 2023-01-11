<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Community;
use App\Models\Section;
use App\Models\SectionSetting;
use App\Models\SectionUser;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Section as SectionTrait;
use App\Traits\Site as SiteTrait;
use App\Traits\Utils;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends Controller
{
    use \App\Traits\SectionSetting;

    use SectionTrait, SiteTrait, Utils, Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity(Section::class);
    }

    public function index(): Factory|View
    {
        return $this->show();
    }

    /**
     * @param $path
     * @param $id
     * @return Factory|View
     */
    public function show($path = null, $id = null)
    {
        if ($path && $id) {
            $site = get_site();
            $section = Section::query()->bySite($site->id)->whereId($id)->first();
            if ($section) {
                $this->getMeta(__METHOD__, $section);
            }
        }

        return view(session('theme'), ['ssr' => self::ssr()]);
    }
}
