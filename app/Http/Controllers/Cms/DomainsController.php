<?php

namespace App\Http\Controllers\Cms;

use App\Helpers\Deployer\Classes\Deployer;
use App\Models\BlogSite;
use App\Models\Domain;
use App\Models\DomainThematic;
use App\Models\DomainVolume;
use App\Models\Language;
use App\Models\Site as SiteModel;
use App\Models\TemplateScheme;
use App\Models\User;
use App\Traits\CustomValidators;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Traits\Utils;
use App\Utils\CmsFilter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Schema;
use Validator;

class DomainsController extends CmsController
{
    use DomainTrait;
    use Site;
    use CustomValidators;
    use Utils;

    public array $domainTypes = [
        Domain::DOMAIN_TYPE_THEMATIC => 'Тематический',
        Domain::DOMAIN_TYPE_PERSONAL => 'Персональный',
        Domain::DOMAIN_TYPE_SYSTEM => 'Системный',
        Domain::DOMAIN_TYPE_LANGUAGE => 'Мультиязычный'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->breadcrumbs[] = ['Домены', 'domains.index'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index(): Factory|Response|View|Application
    {
        $title = 'Домены';

        $filter = new CmsFilter(Domain::class, 'domains.index');
        $filter = $filter->addField('name', 'Имя домена')
            ->addButton('Создать', 'domains.create')->render();

        $domain = Domain::query();

        $breadcrumbs = $this->breadcrumbs;
        $fields = $this->setFields($domain);
        $domainTypes = $this->domainTypes;

        return view('cms.domains.index', compact('filter', 'title', 'breadcrumbs', 'fields', 'domainTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create(): Factory|Response|View|Application
    {
        $title = 'Новый домен';

        $this->breadcrumbs[] = ['Создание'];
        $breadcrumbs = $this->breadcrumbs;
        $form = new Domain();
        $action = 'domains.store';
        $domainTypes = $this->domainTypes;
        $language = Language::query()->orderBy('priority', 'asc')->get()->pluck('title', 'id');
        $thematic = DomainThematic::query()->orderBy('name', 'asc')->get()->pluck('name', 'id');
        $users = User::selectOptions(null, true);

        return view('cms.domains.new_form', compact('form', 'title', 'breadcrumbs', 'action',
            'domainTypes', 'language', 'thematic', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(Request $request): RedirectResponse
    {
        $inputData = $request->all();

        $mainDomain = main_domain($inputData['name']);

        $domain = Domain::whereName($mainDomain)->first();

        if ($domain) {
            switch ($domain->domain_type) {
                case Domain::DOMAIN_TYPE_PERSONAL:
                    return redirect()->back()->withInput($inputData)->withErrors('Нельзя
                     создавать поддомен у персонального домена');

                case Domain::DOMAIN_TYPE_SYSTEM:
                    return redirect()->back()->withInput($inputData)->withErrors('Нельзя
                     создавать поддомен у системного домена');
            }
        }

        $validator = static::getValidator($inputData);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            if (isset($inputData['is_customer_domain']) && (int)$inputData['is_customer_domain'] === 1) {
                if (empty($inputData['user_id'])) {
                    return redirect()->back()->withInput($inputData)->withErrors('Не выбран пользователь для домена');
                }
            }

            if (env('DEVELOPMENT') == true) {
                $env = 0;
            } else {
                $env = 1;
            }

            $parentId = null;

            $domainName = strtolower($inputData['name']);

            if (substr_count($domainName, '.') > 1) {
                $parsedDomain = explode('.', $domainName);
                if (!empty($parsedDomain)) {
                    $parentDomain = Domain::whereName($parsedDomain[count($parsedDomain) - 2] . '.' .
                        $parsedDomain[count($parsedDomain) - 1])->get()->first();

                    $parentId = $parentDomain?->id;
                }
            }

            $pvc = DomainVolume::createPvc();

            $data = [
                'environment' => $env,
                'parent_id' => $parentId,
                'name' => $domainName,
                'domain_type' => $inputData['domain_type'],
                'language_id' => $inputData['language_id'] ?? null,
                'domain_thematic_id' => $inputData['domain_thematic_id'] ?? null,
                'hide_from_registration' => isset($inputData['hide_from_registration']) ? 1 : 0,
                'active' => isset($inputData['active']) ? 1 : 0,
                'domain_volume_id' => $pvc->id
            ];

            if (isset($inputData['is_customer_domain']) && $inputData['is_customer_domain'] == true) {
                $data = [
                        'is_customer_domain' => isset($inputData['is_customer_domain']) ? 1 : 0,
                        'user_id' => (int)$inputData['user_id'] ?? null
                    ] + $data;
            }

            $domain = Domain::query()->firstOrCreate(['name' => $domainName], $data);

            $siteExists = SiteModel::whereDomain($domain->name)->first();

            if (!$siteExists && in_array($domain->domain_type,
                    [Domain::DOMAIN_TYPE_SYSTEM, Domain::DOMAIN_TYPE_PERSONAL])) {

                $siteRoot = SiteModel::root();

                $scheme = TemplateScheme::whereDefaultGlobal(1)->get()->first();
                $schemeId = $scheme?->id;

                $newSite = SiteModel::query()->firstOrCreate(['domain' => $domain->name], [
                    'title' => $domain->name,
                    'domain_id' => $domain->id,
                    'domain' => $domain->name,
                    'template_scheme_id' => $schemeId
                ]);

                self::createDefaultMenu($newSite);
                $this->updateSiteSettings($newSite);

                if ($siteRoot) {
                    $newSite->makeChildOf($siteRoot);
                }
            }

            (new Deployer($domain->name, $domain->domainVolume))->v1();
        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('domains.index');

    }

    public static function getValidator($data, $update = false)
    {
        if ($update == true) {
            $rules = ['domain_thematic_id' => 'required'];
        } else {
            $rules = [
                'name' => 'required|unique:domain|domain_valid'
            ];
        }

        $messages = [
            'domain_thematic_id.required' => 'Не задана тематика',
            'name.unique' => 'Такой домен уже в системе',
            'name.requied' => 'Напишите название домена',
            'name.domain_valid' => 'Невалидный домен или у домена не прописаны NS сервера'
        ];

        if ($update == true) {
            unset($messages['name.unique'], $messages['name.required'], $messages['name.domain_valid']);
        }

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id): Factory|View
    {
        $title = 'Домены';

        $form = Domain::query()->find($id);
        $this->breadcrumbs[] = ['Редактирование'];
        $breadcrumbs = $this->breadcrumbs;
        $action = 'domains.update';
        $domainTypes = $this->domainTypes;
        $language = Language::query()->orderBy('priority')->get()->pluck('title', 'id')->toArray();
        $thematic = DomainThematic::query()->orderBy('name')->get()->pluck('name', 'id')->toArray();
        $users = User::selectOptions(null, true);

        return view('cms.domains.edit', compact('form', 'title', 'breadcrumbs',
            'action', 'domainTypes', 'language', 'thematic', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $inputData = $request->all();
        $validator = static::getValidator($inputData, true);

        $domain = Domain::query()->find($id);

        if ($validator->fails()) {
            return redirect()->back()->withInput($inputData)->withErrors($validator);
        } else {

            if (isset($inputData['is_customer_domain']) && (int)$inputData['is_customer_domain'] === 1) {
                if (empty($inputData['user_id'])) {
                    return redirect()->back()->withInput($inputData)->withErrors('Не выбран пользователь для домена');
                }
            }

            $environment = env('ENV');
            if (env('DEVELOPMENT') == true) {
                $env = 0;
            } else {
                $env = 1;
            }

            $parentId = null;

            $data = [
                'environment' => $env,
                'parent_id' => $parentId,
                'domain_type' => $inputData['domain_type'],
                'language_id' => $inputData['language_id'],
                'domain_thematic_id' => $inputData['domain_thematic_id'],
                'hide_from_registration' => isset($inputData['hide_from_registration']) ? 1 : 0,
                'active' => isset($inputData['active']) ? 1 : 0
            ];

            if (isset($inputData['is_customer_domain']) && (int)$inputData['is_customer_domain'] === 1) {
                $data = [
                        'is_customer_domain' => isset($inputData['is_customer_domain']) ? 1 : 0,
                        'user_id' => (int)$inputData['user_id'] ?? null
                    ] + $data;
            } else {
                $data = [
                        'is_customer_domain' => 0,
                        'user_id' => null
                    ] + $data;
            }

            $domain->update($data);

            if (substr_count($domain->name, '.') > 1) {
                $parsedDomain = explode('.', $domain->name);
                if (!empty($parsedDomain)) {
                    $parentDomain = Domain::query()->where('name', $parsedDomain[count($parsedDomain) - 2] . '.' .
                        $parsedDomain[count($parsedDomain) - 1])->get()->first();
                    $parentId = $parentDomain?->id;
                }
            }

            $domain->update([
                'environment' => $env,
                'parent_id' => $parentId
            ]);

            (new Deployer($domain->name, $domain->domainVolume))->v1();

        }

        session()->flash('success', 'Запись сохранена');

        return redirect()->route('domains.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $domain = Domain::find($id);

        $site = SiteModel::where('domain', $domain->name)->first();

        if ($site) {

            $foundPersonal = User::where('domain', 'like', '%' . idnToAscii($site->domain) . '%')->first();

            if ($foundPersonal) {
                return redirect()
                    ->route('domains.index')
                    ->with('error', 'Нельзя удалить персональный домен с пользователями!');
            }

            if (count($site->sections()->whereNotNull('parent_id')->get())) {
                return redirect()
                    ->route('domains.index')
                    ->with('error', 'Нельзя удалить домен если у него есть разделы!');
            }

            if ($site->articles()->withTrashed()->count() > 0) {
                return redirect()
                    ->route('domains.index')
                    ->with('error', 'Нельзя удалить домен если у него есть статьи!');
            }

            if ($site->children()->withTrashed()->count() > 0) {
                return redirect()
                    ->route('domains.index')
                    ->with('error', 'Нельзя удалить домен если у него есть подсайты!');
            }

            forget(Site::class . '.' . idnToAscii($site->domain));
            forget('settings.' . idnToAscii($site->domain));

            $site->forceDelete();
        }

        $this->deleteDomain($domain);

        if ($domain->domain_type == Domain::DOMAIN_TYPE_PERSONAL) {
            $blogSite = BlogSite::whereDomainId($domain->id)->first();
            $blogSite?->delete();
        }

        Schema::disableForeignKeyConstraints();
        $domain->delete();
        Schema::enableForeignKeyConstraints();

        session()->flash('success', 'Запись удалена');

        return redirect(null, 302, [], getenv('HTTP_X_SCHEME') == 'https')->route('domains.index');
    }
}
