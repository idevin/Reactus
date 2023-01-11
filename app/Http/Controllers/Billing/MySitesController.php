<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Site;
use App\Models\User;
use App\Traits\Activity;
use Auth;
use Illuminate\Http\JsonResponse;

class MySitesController extends Controller
{
    use Activity;

    public function __construct()
    {
        parent::__construct();
        $this->setObject(Site::class);
        $this->setUserActivity();
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/profile/sites Сайты, сервисы и тариф
     * @apiGroup Billing sites
     *
     */
    public function index()
    {
        $user = Auth::user();

        $filterDomains = [
            Domain::DOMAIN_TYPE_PERSONAL,
            Domain::DOMAIN_TYPE_LANGUAGE
        ];

        $sites = $user->sites()->get()->map(function ($site) use ($user, $filterDomains) {

            if ($site->siteDomain && !in_array($site->siteDomain->domain_type, $filterDomains)
                && $site->siteDomain->user_id != null) {
                return $site->makeHidden(['siteDomain', 'setting']);
            }
            return null;

        })->filter()->values()->toArray();

        $data = [
            'sites' => $sites
        ];

        return $this->success($data);
    }
}
