<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Domain;
use Auth;
use Cache;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    use \App\Traits\Site;
    use Activity;
    use Domain;

    public function __construct()
    {
        parent::__construct();
        $this->setSiteUserActivity();
    }

    public function sales(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function admin(): Factory|View|Application
    {
        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function index(): Factory|View|Application
    {
        $site = get_site();

        $this->getMeta(__METHOD__, $site);

        return view(session('theme'), ['ssr' => self::ssr()]);
    }

    public function error500(Request $request): Factory|View|Application
    {
        $result = 0;
        try {
            $result = 1 / 0;
        } catch (Exception $e) {
            $exception = FlattenException::create($e);

            debugvars($e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
                'code' => $exception->getStatusCode()
            ]);
        }

        return view(session('theme'), ['ssr' => self::ssr(), 'result' => $result]);
    }

    public function unsupportedBrowser(Request $request): Factory|View|Application
    {
        return view('partials.unsupported-browser', ['ssr' => self::ssr()]);
    }

    public function cookie(): Redirector|Application|RedirectResponse
    {
//        $cCookie = self::cCookie(env('DOMAIN'), $user->getUserString());
        return redirect(route('home', [], false), 302, [], config('session.secure'));
    }

    public function login($id): bool|Application|RedirectResponse|Redirector
    {
        $id = decrypt($id, false);
        $user = User::query()->find($id);

        if ($user) {
            \Auth::loginUsingId($user->id, true);

            if (empty($user->image)) {

                $color = $user->getColor();

                $imageName = Str::random() . '.jpg';

                $user->generateImage(70, 70, $imageName, $color, 'avatar', $user->username);

                $user->update([
                    'image' => $imageName
                ]);
            }
        } else {
            return redirect('/404', 302, [], config('session.secure'));
        }

        $socialKey = 'social.' . $user->id;

        $fromSocial = Cache::get($socialKey);

        if ($fromSocial) {

            $prefix = getSchema();

            $cCookie = self::cCookie($fromSocial['domain'], $user->getUserString());

            forget($socialKey);

            return redirect($prefix . $fromSocial['domain'] .
                route('home.login', ['id' =>encrypt($user->id, false)], false))->withCookie($cCookie);
        } else {
            $cCookie = self::cCookie(env('DOMAIN'), $user->getUserString());
            return redirect(route('home', [], false), 302, [], config('session.secure'))->withCookie($cCookie);
        }
    }
}