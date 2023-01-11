<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\User;
use App\Traits\Activity;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site as SiteTrait;
use Auth;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DomainsController extends Controller
{
    /**
     * @qctivity done
     */
    use DomainTrait;
    use Activity;

    public function __construct()
    {
        parent::__construct();

        $this->setObject(Domain::class);
        $this->setUserActivity();
    }

    /**
     * @return JsonResponse
     * @api {GET} /api/domains/personal Список пресональных доменов
     * @apiGroup Domains
     *
     * @internal param Request $request
     */
    public function personal()
    {
        $domains = Domain::where(['domain_type' => Domain::DOMAIN_TYPE_PERSONAL])->get(['name', 'id']);
        return $this->success($domains);
    }

    /**
     * @param Request $request
     * @return false|JsonResponse|string
     * @api {GET} /api/domains/check Проверка домена (NS, валидация)
     * @apiGroup Domains
     *
     * @apiParam {string} name имя домена
     * @apiParam {string} token Ключ пользователя
     *
     */
    public function check(Request $request)
    {
        $name = $request->get('name');

        if (!$name) {
            return $this->error('Не найдено имя домена');
        }

        $validator = $this->createSiteDomainValidator(compact('name'));

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        return $this->success();
    }

    /**
     * @param \Request|Request $request
     * @return false|JsonResponse|string
     * @api {POST} /api/domains/check_subdomain Проверка сабдомена
     * @apiGroup Domains
     *
     * @apiParam {string} token Токен ключ пользователя
     * @apiParam {integer} domain_id ID домена из списка тематических доменов
     * @piParam {string} name Имя поддомена
     *
     *
     */
    public function checkSubdomain(Request $request)
    {
        $name = $request->get('name', null);
        $domainId = $request->get('domain_id', null);

        if (!$domainId) {
            return $this->error('Вы не выбрали домен');
        }

        if (!$name) {
            return $this->error('Вы не ввели имя для нового сайта');
        }

        $domain = Domain::thematic()->find($domainId);

        if (!$domain) {
            return $this->error('Домен не найден в системе...');
        }

        $cleanName = trim(slugify($name)) . '.' . $domain->name;
        $subdomain = Domain::whereName(idnToAscii($cleanName))->first();

        if ($subdomain) {
            return $this->error('Такой домен существует в системе. Выберите другой.');
        }

        return $this->success($cleanName);
    }

    /**
     * @return JSON|false|JsonResponse|string
     * @api {POST} /api/domains/thematic Тематические домены
     * @apiGroup Domains
     *
     * @apiParam {string} token Токен ключ пользователя
     *
     */
    public function thematic()
    {
        $domains = Domain::thematic()->get()->pluck('name', 'id')->toArray();

        if (count($domains) == 0) {
            return $this->error('Домены не найдены...');
        }

        $domains = array_map(function ($domain) {
            return idnToUtf8($domain);
        }, $domains);

        return $this->success($domains);
    }

    /**
     * @param Request $request
     * @return JSON|false|JsonResponse|string
     * @api {POST} /api/domains/change_user Изменение пользователя домена
     * @apiGroup Domains
     *
     * @apiParam {int} new_user_id Новый пользователь
     * @apiParam {string} domain_name Имя домена
     * @apiParam {string} token Токен ключ пользователя
     */
    public function changeUser(Request $request)
    {
        $data = $request->all();

        if(!isset($data['new_user_id'])) {
            return $this->error('Новый пользователь не найден');
        }

        if(!isset($data['domain_name'])) {
            return $this->error('Не задан домен');
        }

        $domain = Domain::thematic()->whereName($data['domain_name'])->first();

        if (!$domain) {
            return $this->error('Домен не найден...');
        }

        $newUser = User::find($data['new_user_id']);

        if(!$newUser) {
            return $this->error('Пользователь не найден');
        }

        $oldUser = Auth::user();

        if($oldUser->id !== $domain->user_id || $oldUser->id !== $domain->site->user_id) {
            return $this->error('Вы не можете поменять пользователя домена');
        }

        $domain->update([
            'user_id' => $newUser->id
        ]);

        $domain->site()->update([
            'user_id' => $newUser->id
        ]);

        forget(SiteTrait::getSiteCacheKey());

        return $this->success($domain);
    }
}