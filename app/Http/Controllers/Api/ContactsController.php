<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contacts;
use App\Models\User;
use App\Traits\Activity;
use Auth;
use Illuminate\Http\JsonResponse;

class ContactsController extends Controller
{
    /**
     * @activity done
     */
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Contacts::class);
        $this->setUserActivity();
    }

    /**
     * @api {GET} /api/contacts Страница контактов
     * @apiGroup Contacts
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $site = get_site();

        return $this->success($site);
    }

}