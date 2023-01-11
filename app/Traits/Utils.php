<?php

namespace App\Traits;

use App\Models\BlogSite;
use App\Models\Domain as DomainModel;
use App\Models\DomainVolume;
use App\Models\Menu as MenuModel;
use App\Models\Modules\ModuleArticle;
use App\Models\Modules\ModuleSettings;
use App\Models\Modules\ModuleSlide;
use App\Models\Site;
use App\Traits\Site as SiteTrait;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Validator;

trait Utils
{
    public static function createDefaultMenu($site)
    {
        $menu = [
            [
                'title' => 'Содержание сайта', 'url' => '/sections', 'site_id' => $site->id,
                'alias' => 'sections', 'as_tree' => 1, 'disabled' => 1, 'sort_order' => 1
            ],
            [
                'title' => 'Статьи', 'url' => '/articles', 'site_id' => $site->id,
                'alias' => 'articles', 'disabled' => 1, 'sort_order' => 2
            ]
        ];

        foreach ($menu as $item) {
            $menuObject = MenuModel::whereSiteId($item['site_id'])->whereAlias($item['alias'])->first();
            if (!$menuObject) {
                MenuModel::query()->firstOrCreate($item);
            }
        }
    }

    public static function transformUrl($object): LengthAwarePaginator
    {
        if (get_class($object) == LengthAwarePaginator::class) {
            $currentPath = $object->resolveCurrentPath();
            $basePath = parse_url($currentPath);
            $url = $basePath['path'];

            if (isset($urlParams['fragment'])) {
                $url .= '#' . $basePath['fragment'];
            }
            if (!empty($url)) {
                $object = $object->setPath($url);
                return $object;
            }
        }

        return $object;
    }

    public static function getRobotsTxt(): bool|string|null
    {
        self::getRobotsTemplate();
        $file = self::getRobotsTxtPath();

        if (file_exists($file)) {
            return file_get_contents($file);
        }

        return null;
    }

    public static function getRobotsTemplate(): string
    {
        return file_get_contents(env('PUBLIC_PATH') . DS . '..' . DS . '..' . DS . 'app' .
            DS . 'Server' . DS . 'robots.txt');
    }

    public static function getRobotsTxtPath(): string
    {
        return getenv('DOCUMENT_ROOT') . DS . 'robots.txt';
    }

    public static function getDisallowedRobotsString(): string
    {
        return "User-agent: *\nDisallow: /";
    }

    public static function hasForeignKey($table, $foreignKey, $connection = null): bool
    {
        $db = 'mysql';

        if ($connection) {
            $db = $connection;
        }

        $conn = Schema::connection($db)->getConnection()->getDoctrineSchemaManager();

        $keys = array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));

        return in_array($foreignKey, $keys);
    }

    public static function hasIndex($connection, $tableName, $index): bool
    {
        $sm = Schema::connection($connection)->getConnection()->getDoctrineSchemaManager();
        $indexesFound = $sm->listTableIndexes($tableName);
        $found = false;

        if (array_key_exists($tableName . '_' . $index . '_index', $indexesFound)) {
            $found = true;
        }

        return $found;
    }

    public static function getIp()
    {
        if (!empty(getenv('HTTP_CLIENT_IP'))) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (!empty(getenv('HTTP_X_FORWARDED_FOR'))) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } else {
            $ip = getenv('REMOTE_ADDR');
        }

        return $ip;
    }

    public static function cleanChars($data): string
    {
        $data = preg_replace("/\s+/", " ", $data);
        $data = html_entity_decode($data);
        $data = htmlspecialchars($data);
        return trim($data);
    }

    public static function getSoftDeletables(): array
    {
        $models = self::getAllModels(app_path('Models'));

        $softDeletable = [];

        foreach ($models as $model) {
            $uses = class_uses_recursive($model);
            foreach ($uses as $use) {
                if (preg_match('#SoftDeletes#', $use)) {
                    $softDeletable[] = $model;
                }
            }
        }

        return $softDeletable;
    }

    public static function getAllModels($path): array
    {
        $models = [];
        $files = scandir($path);

        foreach ($files as $file) {

            if ($file === '.' or $file === '..') {
                continue;
            }

            $filename = $path . DS . $file;

            if (is_dir($filename)) {
                $models = array_merge($models, self::getAllModels($filename));
            } else {
                $filename = 'app' . preg_replace('#' . app_path() . '#', '', $filename);
                $filename = preg_replace('#/#', '\\', $filename);
                $filename = substr($filename, 0, -4);
                $models[] = $filename;
            }
        }

        return $models;
    }

    /**
     * @throws Exception
     * @throws Exception
     */
    public static function updatePvcs()
    {
        Schema::disableForeignKeyConstraints();

        DomainVolume::query()->truncate();

        DB::statement('ALTER TABLE `domain_volume` AUTO_INCREMENT = 1');

        $domains = DomainModel::all();

        foreach ($domains as $domain) {
            $pvc = DomainVolume::createPvc();

            $domain->update([
                'domain_volume_id' => $pvc->id
            ]);
        }

        $personalSites = BlogSite::all();

        foreach ($personalSites as $domain) {
            $pvc = DomainVolume::createPvc();

            $domain->update([
                'domain_volume_id' => $pvc->id
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }

    public static function parseTags($tags)
    {
        $tagData = [];
        if (is_string($tags)) {
            if (strstr(',', $tags)) {
                $tagData = explode(',', $tags);
            } else {
                $tagData = @json_decode($tags, true);
            }
        } elseif (is_array($tags)) {
            $tagData = $tags;
        }

        return $tagData;
    }

    /**
     * @param $withEmptyValue
     * @param $withRoot
     * @param $nodes
     * @return array
     */
    public static function getsubTree($withEmptyValue, $withRoot, $nodes): array
    {
        $options = $withEmptyValue ? ['' => 'Выберите...'] : [];

        foreach ($nodes as $node) {
            $nodes2 = $withRoot ? $node->getDescendantsAndSelf() : $node->getDescendants();

            foreach ($nodes2->toArray() as $item) {
                $options[$item['id']] = sprintf('%s %s',
                    str_repeat('&nbsp;', abs($item['depth'] * 3 - 1)) .
                    str_repeat('&#8735;', round($item['depth'] / ($item['depth'] + 0.9))),
                    $item['name']
                );
            }
        }

        return $options;
    }

    public static function nodes($node, $withRoot)
    {
        $nodes = function ($node, $withRoot) {
            return $withRoot ? $node->getDescendantsAndSelf() : $node->getDescendants();
        };

        if ($node) {
            $nodes = $nodes($node, $withRoot);
        }

        return $nodes;
    }

    /**
     * @param $data
     * @param $messages
     * @param $customMessages
     * @param $default
     * @param $customErrors
     * @param $except
     * @return Validator
     */
    public static function makeValidator($data, $messages, $customMessages,
                                         $default, $customErrors, $except): Validator
    {
        $messagesMerged = array_merge($messages, $customMessages);
        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->except($except)->toArray();

        return \Validator::make($data, $rules, $messagesMerged);
    }

    public static function defaultSortRules($o): array
    {
        $o = app($o);

        $default = [
            'view' => 'required|in:' . implode(',', $o::mapConstants($o::$view)),
            'sort_by' => 'required|in:' . implode(',', $o::mapConstants($o::$sortBy)),
            'sort_order' => 'required|in:' . implode(',', $o::mapConstants($o::$sortOrder))
        ];

        $messages = [
            'view.required' => 'Не задан вид блока',
            'sort_by.required' => 'Не задана сортировка',
            'sort_by.in' => 'Неверная сортировка',
            'sort_order.required' => 'Не задан порядок сортировки',
            'sort_order.in' => 'Неверный порядок сортировки'
        ];

        return compact('messages', 'default');
    }

    public static function forgetModuleCache()
    {
        forget(SiteTrait::getSiteCacheKey());
        forget('settings.' . env('DOMAIN'));
        ModuleSettings::flushCache();
        ModuleSlide::flushCache();
        ModuleArticle::flushCache();
    }

    public static function htmlDecode($data): string
    {
        $data = html_entity_decode($data);
        return trim(strip_tags($data));
    }

    public static function siteInstance()
    {

        $site = Site::query()->whereDomain(env('DOMAIN'))->first();

        if (!$site) {
            return Response::response()->error('Сайт не найден');
        }

        return compact('site');
    }

    public static function updateSortOrder($objects, $start = 0)
    {
        for ($i = $start; $i < count($objects); $i++) {
            $objects[$i]->update(['sort_order' => $i + 1]);
        }

        return $objects;
    }

    public static function getAlias()
    {

    }

    public static function mapIds($values): array
    {
        $ids = [];
        foreach ($values as $v) {
            if (!empty($v['id'])) {
                $ids[] = (int)$v['id'];
            }
        }
        return $ids;
    }

    public function getDescendantsWithSort(string $field, string $order, array $directions, array $sortable): Builder
    {
        $sort = strtolower($field);
        $dir = strtolower($order);

        $builder = $this->newQuery();

        if (in_array($dir, $directions) && in_array($sort, array_keys($sortable))) {
            $builder->orderBy($sortable[$sort], $dir);
        }

        if ($this->isScoped()) {
            foreach ($this->scoped as $scopeFld)
                $builder->where($scopeFld, '=', $this->$scopeFld);
        }

        $builder->where($this->getLeftColumnName(), '>', $this->getLeft())
            ->where($this->getLeftColumnName(), '<', $this->getRight());

        return $builder;
    }

    public static function getToken(Request $request)
    {
        if ($request->headers->get('postman-token')) {
            $content = json_decode((string)$request->getContent(), true);

            $token = $content['token'] ?? null;
        } else {
            $token = $request->input('token');
        }

        return $token;
    }

    protected function getRobotsString(array $arRobotsData): string
    {
        $string = '';

        foreach ($arRobotsData as $sUserAgent => $arUserAgentData) {
            $string .= 'User-agent: ' . $sUserAgent . "\n";

            foreach ($arUserAgentData as $key => $value) {

                if ($key == "crawl-delay") {
                    $string .= "Crawl-delay: " . $value . "\n";
                }

                if (!is_array($value)) {
                    continue;
                }

                foreach ($value as $link) {
                    $string .= mb_strtoupper($key[0]) . mb_substr($key, 1) . ': ' . $link . "\n";
                }
            }

            $string .= "\n";
        }

        return $string;
    }
}
