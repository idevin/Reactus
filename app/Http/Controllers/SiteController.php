<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Traits\Activity;
use App\Traits\Utils;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SiteController extends Controller
{
    use \App\Traits\Site;
    use Utils;
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity();
    }

    public function index(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function search(Request $request): LengthAwarePaginator
    {
        $term = $request->get('term', '');

        $qb = Site::query();
        if ($term) {
            $qb->where('title', 'like', "%$term%");
        }

        $results = $qb->paginate(10);
        return Utils::transformUrl($results);
    }
}
