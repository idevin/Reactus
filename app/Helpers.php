<?php

use App\Jobs\Activity as ActivityJob;
use App\Models\Activity;
use App\Models\BlogSite;
use App\Models\Domain;
use App\Models\Setting;
use App\Models\Site;
use App\Models\StorageFile;
use App\Models\User;
use App\Traits\Site as SiteTrait;
use App\Traits\Utils;
use Carbon\Carbon;
use Cocur\Slugify\Slugify;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Jenssegers\Date\Date;
use Symfony\Component\HttpFoundation\Response;
use WebSocket\BadOpcodeException;
use WebSocket\Client;

function array_to_object($d): object
{
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return (object)array_map(__FUNCTION__, $d);
    } else {
        // Return object
        return $d;
    }
}

function push($msg)
{
    $client = new Client('ws://127.0.0.1:8888');

    try {
        $client->send($msg);
    } catch (BadOpcodeException $e) {
        debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
    }
}

function neo4j_skip($page)
{
    return $page;
}

function neo4j_limit($page)
{
    return $page;
}

function get_profile_field($profileFields, $fieldAlias)
{
    $field = null;

    foreach ($profileFields as $profileField) {
        if ($profileField->alias == $fieldAlias) {
            $field = $profileField;
            break;
        }
    }

    return $field;
}

function get_input_type(Field $field)
{

//switch();
}

// File

if (!function_exists('rcopy')) {
    function rcopy($src, $dest)
    {

        // If source is not a directory stop processing
        if (!is_dir($src)) {
            return false;
        }

        // If the destination directory does not exist create it
        if (!is_dir($dest)) {
            if (!mkdir($dest)) {
                // If the destination directory could not be created stop processing
                return false;
            }
        }

        // Open the source directory to read in files
        $i = new \DirectoryIterator($src);
        foreach ($i as $f) {
            if ($f->isFile()) {
                if ($f->getFilename() == '.DS_Store') {
                    continue;
                }
                if ($f->isLink()) {
                    $file = "$dest/" . $f->getFilename();

                    if (file_exists($file)) {
                        unlink($file);
                    }

                    symlink(readlink("$src/" . $f->getFilename()), "$dest/" . $f->getFilename());
                } else {
                    copy($f->getRealPath(), "$dest/" . $f->getFilename());
                }

            } else if (!$f->isDot() && $f->isDir()) {
                rcopy($f->getRealPath(), "$dest/$f");
            }
        }
        return true;
    }
}


function native_city($city): string
{
    $string = '';

    if (!empty($city->title_ru)) {
        $string .= $city->title_ru;
    }
    if (!empty($city->area_ru)) {
        $string .= ', ' . $city->area_ru;
    }
    if (!empty($city->region_ru)) {
        $string .= ', ' . $city->region_ru;
    }

    return $string;
}

function filename_ext($filename)
{
    $pos = strrpos($filename, '.');

    return ($pos !== false) ? substr($filename, $pos + 1) : '';
}


function getLastId($table)
{
    $lastId = 1;

    if (!empty($table)) {

        if (strstr($table, '.')) {
            list($db, $tableName) = preg_split('#\.#', $table);
            DB::setDatabaseName($db);
            $table = $tableName;
        }

        $lastId = DB::select("SHOW TABLE STATUS LIKE '" . $table . "'");

        $lastId = array_map(function ($value) {
            return (array)$value;
        }, $lastId);

        if (!empty($lastId) && isset($lastId[0])) {
            $lastId = $lastId[0];
        }

        $lastId = $lastId['Auto_increment'];
    }

    return $lastId;
}

function theme($template, $default = false)
{
    $theme = session('theme');
    $host = getenv('HTTP_HOST');

    if (!empty($host)) {
        /**
         * Лишние запросы, надо выносить в сервис провайдер
         */
        $site = Site::whereDomain($host)->get()->first();

        if ($site && $site->siteDomain && $site->siteDomain->domain_type != Domain::DOMAIN_TYPE_PERSONAL) {
            if ($site->template) {
                session(['theme' => $site->template->alias]);
                $theme = $site->template->alias;
            }
        }
    }


    if ($default == true) {
        $theme = 'DefaultLayout';
    }

    if ($theme) {
        return 'theme.' . $theme . '.' . $template;
    } else {
        return $template;
    }
}

function get_ns_record($domain): bool
{
    $domain = idnToAscii($domain);
    $records = dns_get_record($domain);

    if (empty($records)) {
        return false;
    }

    $found = null;
    $found2 = null;

    foreach ($records as $record) {

        if (isset($record['class']) && $record['class'] == 'IN' && isset($record['type']) && $record['type'] == 'NS') {
            if (isset($record['target'])) {
                if ($record['target'] == 'ns1.selectel.org') {
                    $found = true;
                }

                if ($record['target'] == 'ns2.selectel.org') {
                    $found2 = true;
                }
            }
        }
    }

    if ($found && $found2) {
        return true;
    }

    return false;
}

function check_domain_name($domain): bool
{
    $domain = idnToAscii($domain);

    if (!strstr($domain, '.')) {
        return false;
    }

    return (preg_match('/^([а-яa-z\d](-*[а-яa-z\d])*)(\.([а-яa-z\d](-*[а-яa-z\d])*))*$/iu', $domain)
        && preg_match('/^.{1,253}$/', $domain)
        && preg_match('/^[^\.]{1,63}(\.[^\.]{1,63})*$/', $domain));
}

function dig_ns_record($domain): bool
{
    exec('dig ns ' . $domain, $execOut);

    if (empty($execOut)) {
        return false;
    }

    foreach ($execOut as $line) {
        if (preg_match('#ns(\d+).selectel.org#', $line)) {
            return true;
        }
    }

    return false;
}

function valid_dns($domain): bool
{
    return dig_ns_record($domain);
}

function is_email($str)
{
    return str_contains($str, '@') && filter_var($str, FILTER_VALIDATE_EMAIL);
}

function is_phone($str)
{
    return preg_match('/^[0-9\s\-\+\(\)]+$/', $str);
}

function is_login($str)
{
    return preg_match('/^[a-z0-9-]+$/gi', $str);
}


function chance_value($chance, $a, $b)
{
    return (rand(0, 100) <= $chance) ? $a : $b;
}

function generate_auth_token($user): string
{
    return sha1($user->id . time() . Str::random(128));
}

function generate_upload_name(): string
{
    return time() . generate_code(8, true);
    // return Hashids::connection('upload')->encode($id);
}

function generate_upload_filename($file): string
{
    $name = generate_upload_name();
    $ext = $file->getClientOriginalExtension();

    return $name . '.' . $ext;
}

function generate_code($length = 6, $case_sensitivity = false)
{
    $code = '';
    $chars = '0123456789aqzxswedcrfvtgbyhnujmiklop';

    if ($case_sensitivity) {
        $chars .= 'QAZWSXEDCRFVTGBYHNUJMKILOP';
    }

    for ($i = 0; $i < $length; $i++) {
        $chars = str_shuffle($chars);
        $code .= $chars[0];
    }

    return $code;
}

function queryFilter($alias, $reversed = false): string
{
    if ($reversed == true) {
        $alias = '-' . $alias;
    }

    return http_build_query(['ord' => $alias] + request()->all());
}

function format_bytes($bytes, $decimals = 2): string
{
    $sizes = config('storage.file_sizes');

    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $sizes[(int)$factor];
}

function generate_password($length = 9): string
{
    return generate_code($length);
}

function sendEmail($email, $subject, $data, $tpl, $files = [], $domain = null)
{
    /**
     * @param $email
     * @param $subject
     * @param $data
     * @param $tpl
     * @param array $arFiles
     * @param null $domain
     */
    $sender = function ($email, $subject, $data, $tpl, $arFiles = [], $domain = null) {

        if (!$domain) {
            $domain = main_domain(env('DOMAIN'));
        }

        $data['_subject'] = $subject;
        $data['_site'] = Site::whereDomain($domain)->first();
        $data['_doc_root'] = getenv('DOCUMENT_ROOT');
        $templateName = 'emails.' . $tpl;

        try {
            \Mail::send($templateName, $data, function ($message) use ($email, $subject, $arFiles, $domain) {
                $fromSender = env('MAIL_NOREPLY');

                /**
                 * Domain name as sender?
                 *
                 * $domainName = preg_split('#\.#', $domain, -1);
                 * $domainName = ucfirst($domainName[0]);
                 */

                $message->from($fromSender, 'ReactOm');
                $message->sender($fromSender, 'ReactOm');

                if (!empty($arFiles)) {
                    foreach ($arFiles as $file) {
                        if (!is_string($file)) {
                            continue;
                        }
                        $message->attach($file);
                    }
                }

                $message->to($email)->subject($subject);
            });


        } catch (Swift_TransportException $e) {
            debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
        }
    };

    if (is_array($email)) {
        foreach ($email as $index => $mailString) {
            $sender($mailString, $subject, $data, $tpl, $files, $domain);
        }
    } else {
        $sender($email, $subject, $data, $tpl, $files, $domain);
    }

    foreach ($files as $sFile) {
        try {
            unlink($sFile);
        } catch (Exception $e) {
        }
    }
}

function send_sms($phone, $message)
{
    $cleanPhone = preg_replace('/[^\d]+/', '', $phone);

    $ch = curl_init('http://sms.ru/sms/send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'api_id' => env('SMSRU_API_ID'),
        'to' => $cleanPhone,
        'text' => $message
    ]);

    curl_exec($ch);
    curl_close($ch);
}

function counter_format($cnt): string
{
    return number_format($cnt, 0, '.', ' ');
}

function rating_format($v): string
{
    return number_format($v, 1, '.', ' ');
}

function datetime_format($carbon = null, $useMinutes = true): string|null
{

    $localized = function ($carbon) use ($useMinutes) {
        $string = $carbon->format('d') . ' ' . __('date.' . $carbon->month) . ' ' . $carbon->year . 'г. ';

        if ($useMinutes == true) {
            $string .= 'в ' . $carbon->format('H:i');
        }

        return $string;
    };

    if ($carbon instanceof Carbon) {

        return $localized($carbon);

    } elseif (is_string($carbon)) {

        $carbon = Carbon::parse($carbon);
        return $localized($carbon);

    } else {
        return $carbon;
    }
}

function section_path_format($section)
{
    return $section->getAncestorsAndSelf()->pluck('title')->implode(' / ');
}

function truncate_content($html, $maxLength = 200, $isUtf8 = true, $stripTags = false, $showDots = true)
{
    $printedLength = 0;
    $position = 0;
    $tags = [];

    $re = $isUtf8
        ? '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;|[\x80-\xFF][\x80-\xBF]*}'
        : '{</?([a-z]+)[^>]*>|&#?[a-zA-Z0-9]+;}';
    $data = null;

    while ($printedLength < $maxLength && preg_match($re, $html, $match, PREG_OFFSET_CAPTURE, $position)) {
        list($tag, $tagPosition) = $match[0];

        $str = substr($html, $position, $tagPosition - $position);
        if ($printedLength + strlen($str) > $maxLength) {
            $data .= substr($str, 0, $maxLength - $printedLength);
            $printedLength = $maxLength;
            break;
        }

        $data .= $str;
        $printedLength += strlen($str);
        if ($printedLength >= $maxLength) break;

        if ($tag[0] == '&' || ord($tag) >= 0x80) {
            $data .= $tag;
            $printedLength++;
        } else {
            $tagName = $match[1][0];
            if ($tag[1] == '/') {
                $openingTag = array_pop($tags);
                assert($openingTag == $tagName);

                $data .= $tag;
            } else if ($tag[strlen($tag) - 2] == '/') {
                $data .= $tag;
            } else {
                $data .= $tag;
                $tags[] = $tagName;
            }
        }

        $position = $tagPosition + strlen($tag);
    }

    if ($printedLength < $maxLength && $position < strlen($html))
        $data .= substr($html, $position, $maxLength - $printedLength);

    while (!empty($tags)) {
        sprintf('</%s>', array_pop($tags), $data);
    }

    if ($stripTags == true) {
        $data = preg_replace('#<[^>]+>#', ' ', $data);
        $data = preg_replace('#\s+#', ' ', $data);
    }

    $moreDots = '';

    if ($showDots == true) {
        $moreDots = '...';
    }

    if (mb_strlen($data) < $maxLength) {
        $moreDots = '';
    }

    return trim($data) . $moreDots;
}

function get_site()
{
    $site = null;

    if (!empty(env('DOMAIN'))) {

        $siteClass = Site::class;
        $siteKey = Site::getSiteCacheKey();
        $isPersonal = false;

        $site = \Cache::get($siteKey);

        if (!$site) {
            $mainDomain = main_domain(env('DOMAIN'));
            $envDomain = env('DOMAIN');
            $envDomainParts = preg_split('#\.#', $envDomain);
            $domain = Domain::query()->whereName($mainDomain)->first();

            if ($domain) {
                if ($domain->domain_type == Domain::DOMAIN_TYPE_PERSONAL && count($envDomainParts) == 3) {
                    $siteClass = BlogSite::class;
                    $siteKey = $siteClass . '.' . env('DOMAIN');
                    $isPersonal = true;
                }
            }

            $site = $siteClass::whereDomain($envDomain)->first();

            if ($isPersonal && !$site) {
                $site = $siteClass::firstOrCreate([
                    'domain' => env('DOMAIN'),
                    'domain_id' => $domain->id
                ]);
            }
            if ($site) {
                remember($siteKey, function () use ($site) {
                    return $site;
                });
            }
        }
    }

    return $site;
}

function comment_is_short($str): bool
{
    return mb_strlen(strip_tags($str), 'utf8') <= 100;
}

/**
 * @param $text
 * @param null $noResponse
 * @return ResponseFactory|string|Response
 * @throws Throwable
 */
function error404($text, $noResponse = null)
{
    $view = view('theme.' . Session::get('theme') . '.errors.404', compact('text'))->render();

    if (!$noResponse) {
        return response($view, 404);
    } else {
        return $view;
    }
}

/**
 * @param $text
 * @param null $noResponse
 * @return ResponseFactory|string|Response
 * @throws Throwable
 */
function error403($text, $noResponse = null)
{
    $view = view(theme('errors.403'), compact('text'))->render();

    if (!$noResponse) {
        return response($view, 403);
    } else {
        return $view;
    }
}

function comment_is_lowrating($rating): bool
{
    return $rating <= 0;
}

/**
 * @return string|null
 */
function geo(): string|null
{
    $ip = (new class {
        use Utils;
    })::getIp();

    $location = geoip($ip);
    $locationArray = $location->toArray();
    $locationString = implode('#', $locationArray);
    $cacheKey = sha1($locationString) . md5($locationString);

    if (!\Cache::has($cacheKey)) {
        $locationArray = remember($cacheKey, function () use ($locationArray) {
            return json_encode($locationArray);
        });
    } else {
        $locationArray = Cache::get($cacheKey);
    }

    return $locationArray;
}


/**
 * @param $user
 * @param $fromUser
 * @param array $o
 * @param array $fromO
 * @param null $title
 * @param null $description
 * @param null $params
 * @param null $request
 * @param int $isApi
 * @param int $isSystem
 * @param int $statusCode
 * @param null $activityError
 * @param int $isContent
 * @return boolean|void
 */
function activity(
    $user,
    $fromUser, $o = ['o' => null, 'o_id' => null], $fromO = ['from_o' => null, 'from_o_id' => null],
    $title = null, $description = null, $params = null, $request = null, $isApi = 0, $isSystem = 0,
    $statusCode = 200, $activityError = null, $isContent = 0)
{

    if (!isset($_COOKIE[config('session.cookie')])) {
        return false;
    }

    if (!$request) {
        $request = request();
    }

    $siteClass = new class {
        use SiteTrait;
    };

    $request = $request->all();

    unset($request['file'], $request['files']);

    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        putenv('HTTP_USER_AGENT=UNKNOWN');
    }

    $browser = get_browser(null, true);
    $location = json_decode(geo(), true);
    $sessionName = substr($_COOKIE[config('session.cookie')], 0, 5);

    $deviceString = $browser['device_type'] ?? null;

    $server = Activity::params($_SERVER);
    $env = Activity::params($_ENV);

    $activityName = 'activity_object.' . preg_replace("/\\\/", '_', $o['o']);

    $site = $siteClass->getSite(main_domain(env('DOMAIN')));
    $timeNow = Carbon::now();

    $browserBits = null;
    $platformBits = null;
    $browserString = null;
    $platformString = null;

    if ($browser) {
        if (isset($browser['browser_bits'])) {
            $browserBits = $browser['browser_bits'];
        }

        if (isset($browser['platform_bits'])) {
            $platformBits = $browser['platform_bits'];
        }

        $browserString = isset($browser['browser']) ?
            ($browser['browser'] . $browserBits) : null;

        $platformString = isset($browser['platform']) ?
            ($browser['platform'] . $platformBits) : null;
    }

    $ip = (new class {
        use Utils;
    })::getIp();

    $data = [
        'o' => $o['o'],
        'o_id' => $o['o_id'],
        'from_o' => $fromO['from_o'],
        'from_o_id' => $fromO['from_o_id'],
        'user_id' => $user?->id,
        'from_user_id' => $fromUser?->id,
        'title' => $title,
        'description' => $description,
        'params' => $params,
        'request' => $request,
        'env' => $env,
        'server' => $server,
        'browser' => $browser,
        'ip' => $ip,
        'uri' => getenv('REQUEST_URI'),
        'browser_string' => $browserString,
        'country_string' => $location['country'],
        'device_string' => $deviceString,
        'oc' => $platformString,
        'domain' => idnToUtf8(env('DOMAIN')),
        'referer' => getenv('HTTP_REFERER'),
        'location' => $location,
        'location_city' => $location['city'],
        'location_lat' => $location['lat'],
        'location_lon' => $location['lon'],
        'session_name' => $sessionName,
        'object_string' => $activityName,
        'is_api' => $isApi,
        'is_system' => $isSystem,
        'is_content' => $isContent,
        'http_status_code' => $statusCode,
        'error' => $activityError,
        'site_id' => $site->id,
        'date_only' => $timeNow
    ];

    $jobInstance = new ActivityJob($data, getenv('DOCUMENT_ROOT'));

    if ((int)config('app.activity_job') == 1) {
        $job = ($jobInstance)->onQueue('activity')
            ->delay($timeNow->addMinutes(1));

        dispatch($job);
    } else {
        $jobInstance->handle();
    }
}

function getSchema(): string
{
    $scheme = getenv('HTTP_X_SCHEME', 'http');

    if (config('session.scheme')) {
        $scheme = config('session.scheme');
    }

    return $scheme . '://';
}

// Route helpers
function ajax_base_url(): string
{
    $schema = config('session.scheme');
    $domain = main_domain(env('DOMAIN'));
    $port = getPort();

    return "$schema://$domain" . "$port/api/";
}

function validDomain($domain)
{
    return (preg_match('/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i', $domain)
        && preg_match('/^.{1,253}$/', $domain)
        && preg_match('/^[^\.]{1,63}(\.[^\.]{1,63})*$/', $domain));
}

function settings()
{
    $settingsKey = 'settings.' . env('DOMAIN');

    $settings = \Cache::get($settingsKey);

    if (!$settings) {
        $site = get_site();

        if ($site) {
            $settings = Setting::query()->where(['site_id' => $site->id])
                ->remember(config('app.remember_time'))->get()->first();

            if ($settings) {
                remember($settingsKey, function () use ($settings) {
                    return $settings;
                });
            }
        }
    }

    return $settings;
}

function permissions($user = null, $jsonEncode = true, $section = null, $siteClass = Site::class): bool|array|string
{
    $permissionsData = [];

    $fPermissions = function ($arrayPermissions) use (&$permissionsData, $user) {

        foreach ($arrayPermissions->permissions as $permission) {

            $permissionsData[] = [
                'name' => $permission['name'],
                'own' => $permission['pivot']['own'],
                'other' => $permission['pivot']['other'],
                'permission_id' => $permission['id'],
                'id' => $permission['id']
            ];
        }

        return $permissionsData;
    };

    if (!$user) {
        $user = auth()->user();
    }

    $ownSite = false;
    $newData = [];

    $siteClass = new class($siteClass) {
        use SiteTrait;

        public static $site = null;

        public function __construct($site)
        {
            if (self::$site == null) {
                $this->setSiteClass($site);
            }
        }

        public function site()
        {
            return $this->getSite(env('DOMAIN'), $this->getSiteClass());
        }

        public function setSiteClass($site)
        {
            self::$site = $site;
        }

        public function getSiteClass()
        {
            return self::$site;
        }
    };

    $siteOrigin = $siteClass->site();

    if ($user) {
        $domainParts = preg_split('#\.#', env('DOMAIN'));

        if ($siteOrigin->siteDomain && $siteOrigin->siteDomain->domain_type == Domain::DOMAIN_TYPE_PERSONAL
            && count($domainParts) == 3) {

            if ($domainParts[0] == $user->username) {
                $ownSite = true;
            }

        } else {
            if ($siteOrigin->user_id == $user->id) {
                $ownSite = true;
            } else {
                if ($siteOrigin->siteUsers) {
                    foreach ($siteOrigin->siteUsers as $siteUser) {
                        if ($siteUser->user_id == $user->id && $siteOrigin->id == $siteUser->site_id) {
                            $ownSite = true;
                            break;
                        }
                    }
                }
            }
        }

        $roles = $user->roles()->get();
        if (!empty($roles)) {
            foreach ($roles as $role) {
                $fPermissions($role);
            }
        }

        if ($siteOrigin->siteUsers && count($siteOrigin->siteUsers) > 0) {

            foreach ($siteOrigin->siteUsers as $siteUser) {
                if (($siteUser->user_id == $user->id && $siteOrigin->id == $siteUser->site_id)) {
                    $roles = $siteUser->roles()->get();
                    foreach ($roles as $role) {
                        $fPermissions($role->role);
                    }
                }
            }
        }

        if ($section && count($user->sectionRoles) > 0) {
            foreach ($user->sectionRoles as $sectionRole) {
                $fPermissions($sectionRole->role);
            }
        }

        $fPermissions($user);

        $allPermissions = collect($permissionsData)->map(function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'pivot' => [
                    'own' => $item['own'],
                    'other' => $item['other']
                ]
            ];
        });

        $pData = User::groupPermissions(collect($allPermissions), $user);

        foreach ($pData as $permission) {
            if (User::catchPermission($permission['own'], $permission['other'], $ownSite) == true) {
                $newData[] = [
                    'name' => $permission['name'],
                    'own' => $permission['own'],
                    'other' => $permission['other']
                ];
            }
        }
    }

    if ($jsonEncode == true) {
        return json_encode($newData);
    } else {
        return $newData;
    }
}

function minute_difference($to, $from)
{
    return round(abs(strtotime($to) - strtotime($from)) / 60, 2);
}

function object_minute_difference($nextObject, $object)
{
    return round(abs(strtotime($nextObject->created_at) - strtotime($object->created_at)) / 60, 2);
}

if (!function_exists('main_domain')) {
    function main_domain($domain)
    {
        $parts = explode('.', $domain);

        if (count($parts) > 1) {
            $tmp = [];
            $tmp[] = array_pop($parts);
            $tmp[] = array_pop($parts);

            $domain = implode('.', array_reverse($tmp));
        }

        return $domain;
    }
}

function parse_cookies($str)
{
    $cookies = [];
    foreach (explode('; ', $str) as $k => $v) {
        preg_match('/^(.*?)=(.*?)$/i', trim($v), $matches);

        if (!empty($matches)) {
            $cookies[trim($matches[1])] = urldecode($matches[2]);
        }
    }

    return $cookies;
}

/**
 * @param User $user
 * @return string
 */
function route_to_public_profile($user)
{
    $schema = getSchema();
    $domain = $user->domain;

    if (!$domain) {
        $oDomain = Domain::query()->where('domain_type', Domain::DOMAIN_TYPE_PERSONAL)
            ->where('is_default', 1)->get()->first();

        if ($oDomain) {
            $domain = $user->username . '.' . $oDomain->name;
            $user->setConnection('mysqlu');
            $user->update([
                'domain' => $domain
            ]);
        } else {
            return route('profile.edit');
        }
    }

    return $schema . $domain;
}

function getPort()
{
    return null;
}

function slugify($string = '', $uniqueId = true, $replacement = '-')
{
    $slugifyer = new Slugify();

    $options = [
        'lowercase' => true
    ];

    $string = $slugifyer->slugify($string, $options);

    $string = preg_replace('/[^\d\w\-\_]+/i', $replacement, $string);
    $string = strip_tags(trim($string, $replacement));

    if (empty($string) && $uniqueId == true) {
        $string = uniqid();
    }

    return $string;
}

function remember($key, $closure, $ttl = 24 * 365 * 60)
{
    return \Cache::remember($key, $ttl, $closure);
}

function forget($key)
{
    \Cache::forget($key);
}

function redirectTo($url)
{
    $urlParts = parse_url($url);
    $urlText = '';

    if (!empty($urlParts)) {
        $urlText .= $urlParts['scheme'];
        $urlText .= $urlParts['host'];
        $urlText .= getPort();
        $urlText .= (isset($urlParts['path'])) ? $urlParts['path'] : '';
        $url = $urlText;
    }

    return route('redirect.index', ['url' => $url]);
}

function route_to_article($entity, $relative = false, $isBlog = false)
{
    if (empty($entity) || !$entity) {
        return null;
    }

    $id = is_array($entity) ? $entity['id'] : $entity->id;
    $title = is_array($entity) ? $entity['slug'] : $entity->slug;
    $schema = getSchema();
    $domain = is_array($entity) ? $entity['site']['domain'] :
        ($entity->site ? idnToAscii($entity->site->domain) : env('DOMAIN'));

    $port = getPort();

    if (empty($title)) {
        $mainTitle = is_array($entity) ? $entity['title'] : $entity->title;
        $title = slugify($mainTitle);
    }

    if ($isBlog == false) {
        $routeName = 'article.show';
    } else {
        $routeName = 'profile.blog.article_show';
    }

    if ($relative == false) {
        return "$schema$domain$port" . route($routeName, ['title' => $title, 'id' => $id], $relative);
    } else {
        $domainParts = [];
        if ($isBlog == true) {
            $domainParts = preg_split('/\./', env('DOMAIN'), 2);
        }

        $params = ['title' => $title, 'id' => $id];

        if (!empty($domainParts)) {
            $params['login'] = $domainParts[0];
        }

        return route($routeName, $params, false);
    }
}

function route_to_section($entity, $relative = false, $isBlog = false)
{

    $path = is_array($entity) ? $entity['path'] : $entity->path;

    $id = is_array($entity) ? $entity['id'] : $entity->id;
    $domain = is_array($entity) ? $entity['site']['domain'] :
        ($entity->site ? idnToAscii($entity->site->domain) : env('DOMAIN'));

    $parentId = is_array($entity) ? $entity['parent_id'] : $entity->parent_id;

    if (!$parentId) {
        $sectionsSlug = route('section.index', [], false);
        if ($relative == false) {
            $url = getSchema() . $domain . $sectionsSlug;
        } else {
            $url = $sectionsSlug;
        }

        return $url;
    }

    if ($isBlog == false) {
        $routeName = 'section.show';
    } else {
        $routeName = 'profile.blog.section_show';
    }

    if ($relative == false) {

        $urlParams = parse_url(route($routeName, ['section' => ltrim($path, '/'), 'id' => $id]));

        $url = $urlParams['scheme'] . '://' . $domain . getPort() . $urlParams['path'];

        if (isset($urlParams['query'])) {
            $url .= '?' . $urlParams['query'];
        }
        if (isset($urlParams['fragment'])) {
            $url .= '#' . $urlParams['fragment'];
        }

        return $url;

    } else {
        $domainParts = [];
        if ($isBlog == true) {
            $domainParts = preg_split('/\./', env('DOMAIN'), 2);
        }

        $params = ['section' => ltrim($path, '/'), 'id' => $id];

        if (!empty($domainParts)) {
            $params['login'] = $domainParts[0];
        }

        return route($routeName, $params, false);
    }
}

function route_to_hidden_section($entity, $relative = false)
{
    $path = is_array($entity) ? $entity['path'] : $entity->path;
    $id = is_array($entity) ? $entity['id'] : $entity->id;

    if ($relative == false) {
        return route('section.hidden.show', ['path' => ltrim($path, '/'), 'key' => sha1($id), 'id' => $id], true);
    } else {
        return route('section.hidden.show', ['path' => ltrim($path, '/'), 'key' => sha1($id), 'id' => $id], false);
    }

}

function route_to_community($entity)
{
    //return route('community.show', ['id' => $entity->id]);

    $path = is_array($entity) ? $entity['path'] : $entity->path;
    return route('community.show', ['path' => $path]);
}

function route_to_site($entity): string
{
    $schema = getSchema();
    $domain = is_array($entity) ? $entity['domain'] : $entity->domain;
    $port = getPort();

    return "$schema$domain$port";
}

// Path helpers
function user_storage_path($user, $folder = ''): string
{
    $id = is_int($user) ? $user : null;

    if (!$id && $user instanceof User) {
        $id = $user->id;
    }

    return upload_path("storage" . DS . "files" . DS . $id . DS . $folder);
}

function user_storage_url($user, $file)
{
    $id = null;

    if (is_int($user)) {
        $id = $user;
    } elseif ($user instanceof User) {
        $id = $user->id;
    }

    $folder = Hashids::connection('user')->encode($id);
    $data = [
        'path' => "/uploads/storage/users/$folder/$file",
        'url' => url("uploads/storage/users/$folder/$file")
    ];
    return $data;
}


function domain_public_path($path = '')
{
    $publicPath = getenv('DOCUMENT_ROOT') . DS . $path;

    return rtrim($publicPath, DS) . DS;
}

function rolesString($roles)
{
    $rolesArray = $roles->map(function ($role) {
        return $role->description;
    })->toArray();

    return implode(',', $rolesArray);
}

function domain_upload_path($domain = null, $folder = null, $filename = null)
{
    $path = getenv('DOCUMENT_ROOT') . DS . config('netgamer.upload_dir') . DS;

    if ($folder) {
        $path .= $folder . DS;
    }

    if (!file_exists($path)) {
        $fs = new Filesystem();
        $fs->makeDirectory($path, 0775, true);
    }

    return $filename ? $path . $filename : $path;
}

function domain_upload_url($domain, $folder, $file = null)
{
    $data = parse_url(url(config('netgamer.upload_dir') . "/$folder/$file"));

    return $data['scheme'] . "://{$domain}" . $data['path'];
}


// TODO: refactoring
function upload_path($folder = null, $filename = null)
{
    $upload_dir = config('netgamer.upload_dir');
    $public_path = DS . $upload_dir;
    $path = rtrim($public_path, DS) . DS;

    if ($folder) {
        $path .= rtrim($folder, DS) . DS;
    }

    if (!file_exists(public_path($path))) {
        mkdir(public_path($path), 0777, true);
    }

    return $filename ? $path . $filename : $path;
}


function link_to_article_create($route)
{
    return sprintf(
        '<a href="%s" class="btn-create-post"><span class="icon icon-pencil"></span></a>',
        $route
    );
}


// username format
function username($user)
{
    $userString = '';

    if ($user) {
        $userString = $user->first_name .
            ($user->first_name && $user->last_name ? ' [' : '') .
            $user->username .
            ($user->first_name && $user->last_name ? '] ' : '') .
            $user->last_name;
    }

    return trim($userString);
}


function check_found_fields($group, $fieldUserGroups)
{
    $found = false;

    if (!empty($group['fields'])) {
        if ((int)$group['group']->multi_field == 0) {
            foreach ($group['fields'] as $field) {
                if ($field->value && !empty($field->value['value'])) {
                    $found = true;
                    break;
                }
            }
        } else {

            foreach ($fieldUserGroups as $fieldUserGroup) {
                if ($group['group']->id == $fieldUserGroup->field_group_id) {
                    foreach ($fieldUserGroup->field_user_values()->get() as $fieldValue) {
                        if (!empty($fieldValue->value)) {
                            $found = true;
                            break;
                        }
                    }
                }
            }
        }
    }
    return $found;
}

function check_groups_visibility($fieldGroupsArray)
{
    $found = false;

    if (!empty($fieldGroupsArray)) {
        foreach ($fieldGroupsArray as $i => $groupArray) {
            if ($groupArray['user_group'] && $groupArray['user_group']->field_group_id != -1 &&
                $groupArray['user_group']->visibility != 2
            ) {
                $found = true;
                break;
            }
        }
    }

    return $found;
}

function get_activity_template($activity)
{
    $object = $activity->object();
    $fromObject = $activity->fromObject();

    if ($object) {
        $template = strtolower(class_basename($object));
    } else {
        $template = strtolower(class_basename($activity->o));
    }

    $template .= '-with-';

    if ($fromObject) {
        $template .= strtolower(class_basename($fromObject));
    } else {
        $template .= strtolower(class_basename($activity->from_o));
    }

    if (isset($activity->params['template'])) {
        $template .= '-' . $activity->params['template'];
    }

    return $template;
}

if (!function_exists('getFormatedDate')) {

    function getFormatedDate($date, $locale = 'ru', $format = 'j F в H:i')
    {
        Date::setLocale($locale);
        return Date::parse($date)->format($format);
    }

}

function time_ago($date, $locale = 'ru')
{
    Carbon::setLocale($locale);
    if ($date) {
        return $date->diffForHumans(null, true);
    }
    return null;
}

function get_file($url)
{
    $path = parse_url($url)['path'];
    preg_match('/\d+/', $path, $parts);
    $fileId = (int)current($parts);

    return $fileId != 0 ? StorageFile::find($fileId) : null;
}

function upload_base64_file($sBase64_str, $sTargetDir)
{
    $arBlocks = explode(';', $sBase64_str);
    if (count($arBlocks) < 2) {
        return null;
    }
    $decoded_file = base64_decode(explode(',', $arBlocks[1])[1]);
    $mime_type = parseBase64MimeType($sBase64_str);
    if (empty($mime_type)) {
        return null;
    }

    $extension = mime2ext($mime_type);
    if (!$extension) {
        return null;
    }
    $file = uniqid() . '.' . $extension;
    $file_dir = $sTargetDir . $file;
    try {
        file_put_contents($file_dir, $decoded_file);
        return $file_dir;
    } catch (Exception $e) {
        return $e;
    }
}

function mime2ext($mime)
{
    $all_mimes = '{"png":["image\/png","image\/x-png"],"bmp":["image\/bmp","image\/x-bmp",
    "image\/x-bitmap","image\/x-xbitmap","image\/x-win-bitmap","image\/x-windows-bmp",
    "image\/ms-bmp","image\/x-ms-bmp","application\/bmp","application\/x-bmp",
    "application\/x-win-bitmap"],"gif":["image\/gif"],"jpeg":["image\/jpeg",
    "image\/pjpeg"],"xspf":["application\/xspf+xml"],"vlc":["application\/videolan"],
    "wmv":["video\/x-ms-wmv","video\/x-ms-asf"],"au":["audio\/x-au"],
    "ac3":["audio\/ac3"],"flac":["audio\/x-flac"],"ogg":["audio\/ogg",
    "video\/ogg","application\/ogg"],"kmz":["application\/vnd.google-earth.kmz"],
    "kml":["application\/vnd.google-earth.kml+xml"],"rtx":["text\/richtext"],
    "rtf":["text\/rtf"],"jar":["application\/java-archive","application\/x-java-application",
    "application\/x-jar"],"zip":["application\/x-zip","application\/zip",
    "application\/x-zip-compressed","application\/s-compressed","multipart\/x-zip"],
    "7zip":["application\/x-compressed"],"xml":["application\/xml","text\/xml"],
    "svg":["image\/svg+xml"],"3g2":["video\/3gpp2"],"3gp":["video\/3gp","video\/3gpp"],
    "mp4":["video\/mp4"],"m4a":["audio\/x-m4a"],"f4v":["video\/x-f4v"],"flv":["video\/x-flv"],
    "webm":["video\/webm"],"aac":["audio\/x-acc"],"m4u":["application\/vnd.mpegurl"],
    "pdf":["application\/pdf","application\/octet-stream"],
    "pptx":["application\/vnd.openxmlformats-officedocument.presentationml.presentation"],
    "ppt":["application\/powerpoint","application\/vnd.ms-powerpoint","application\/vnd.ms-office",
    "application\/msword"],"docx":["application\/vnd.openxmlformats-officedocument.wordprocessingml.document"],
    "xlsx":["application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application\/vnd.ms-excel"],
    "xl":["application\/excel"],"xls":["application\/msexcel","application\/x-msexcel","application\/x-ms-excel",
    "application\/x-excel","application\/x-dos_ms_excel","application\/xls","application\/x-xls"],
    "xsl":["text\/xsl"],"mpeg":["video\/mpeg"],"mov":["video\/quicktime"],"avi":["video\/x-msvideo",
    "video\/msvideo","video\/avi","application\/x-troff-msvideo"],"movie":["video\/x-sgi-movie"],
    "log":["text\/x-log"],"txt":["text\/plain"],"css":["text\/css"],"html":["text\/html"],
    "wav":["audio\/x-wav","audio\/wave","audio\/wav"],"xhtml":["application\/xhtml+xml"],
    "tar":["application\/x-tar"],"tgz":["application\/x-gzip-compressed"],"psd":["application\/x-photoshop",
    "image\/vnd.adobe.photoshop"],"exe":["application\/x-msdownload"],"js":["application\/x-javascript"],
    "mp3":["audio\/mpeg","audio\/mpg","audio\/mpeg3","audio\/mp3"],"rar":["application\/x-rar","application\/rar",
    "application\/x-rar-compressed"],"gzip":["application\/x-gzip"],"hqx":["application\/mac-binhex40",
    "application\/mac-binhex","application\/x-binhex40","application\/x-mac-binhex40"],
    "cpt":["application\/mac-compactpro"],"bin":["application\/macbinary","application\/mac-binary",
    "application\/x-binary","application\/x-macbinary"],"oda":["application\/oda"],
    "ai":["application\/postscript"],"smil":["application\/smil"],"mif":["application\/vnd.mif"],
    "wbxml":["application\/wbxml"],"wmlc":["application\/wmlc"],"dcr":["application\/x-director"],
    "dvi":["application\/x-dvi"],"gtar":["application\/x-gtar"],"php":["application\/x-httpd-php",
    "application\/php","application\/x-php","text\/php","text\/x-php","application\/x-httpd-php-source"],
    "swf":["application\/x-shockwave-flash"],"sit":["application\/x-stuffit"],"z":["application\/x-compress"],
    "mid":["audio\/midi"],"aif":["audio\/x-aiff","audio\/aiff"],"ram":["audio\/x-pn-realaudio"],
    "rpm":["audio\/x-pn-realaudio-plugin"],"ra":["audio\/x-realaudio"],"rv":["video\/vnd.rn-realvideo"],
    "jp2":["image\/jp2","video\/mj2","image\/jpx","image\/jpm"],"tiff":["image\/tiff"],
    "eml":["message\/rfc822"],"pem":["application\/x-x509-user-cert","application\/x-pem-file"],
    "p10":["application\/x-pkcs10","application\/pkcs10"],"p12":["application\/x-pkcs12"],
    "p7a":["application\/x-pkcs7-signature"],"p7c":["application\/pkcs7-mime","application\/x-pkcs7-mime"],"p7r":["application\/x-pkcs7-certreqresp"],"p7s":["application\/pkcs7-signature"],"crt":["application\/x-x509-ca-cert","application\/pkix-cert"],"crl":["application\/pkix-crl","application\/pkcs-crl"],"pgp":["application\/pgp"],"gpg":["application\/gpg-keys"],"rsa":["application\/x-pkcs7"],"ics":["text\/calendar"],"zsh":["text\/x-scriptzsh"],"cdr":["application\/cdr","application\/coreldraw","application\/x-cdr","application\/x-coreldraw","image\/cdr","image\/x-cdr","zz-application\/zz-winassoc-cdr"],"wma":["audio\/x-ms-wma"],"vcf":["text\/x-vcard"],"srt":["text\/srt"],"vtt":["text\/vtt"],"ico":["image\/x-icon","image\/x-ico","image\/vnd.microsoft.icon"],"csv":["text\/x-comma-separated-values","text\/comma-separated-values","application\/vnd.msexcel"],"json":["application\/json","text\/json"]}';
    $all_mimes = json_decode($all_mimes, true);
    foreach ($all_mimes as $key => $value) {
        if (array_search($mime, $value) !== false) return $key;
    }
    return false;
}

function parseBase64MimeType($sBase64Enc): string
{
    $arTypes = [];
    preg_match('/data:(\w+\/\w+);/', $sBase64Enc, $arTypes);
    if (empty($arTypes) || count($arTypes) < 2) {
        return "";
    }

    return $arTypes[1];
}


function debugvars($message, $context = [])
{
    if (is_array($message) || is_object($message)) {
        $message = json_encode($message, JSON_PRETTY_PRINT);
    }

    Log::debug($message, $context);
}

function idnToAscii($domain): bool|string
{
    return idn_to_ascii($domain, IDNA_DEFAULT);
}

function idnToUtf8($domain): bool|string
{
    return idn_to_utf8($domain, IDNA_DEFAULT);
}

function reloadSite($site)
{
    Session::forget('site');
    Session::put('site', $site);
}

function phoneRegexp(): string
{
    return '/^(([\+]([\d]{2,}))([0-9\.\-\/\s\(\)]{5,})|([0-9\.\-\/\s\(\)]{5,}))*$/';
}


function getNeoDataPath($id)
{

    $fs = new Filesystem();

    $neoBigData = resource_path() . DS . 'neo_big_data' . DS;

    if (!$fs->exists($neoBigData)) {
        $fs->makeDirectory($neoBigData, 0755, true);
    }
    return $neoBigData . $id;
}

function saveNeoDataFile($value, $id): string
{
    $content = encrypt($value);
    $path = getNeoDataPath($id);

    file_put_contents($path, $content);

    return $path;
}

function readNeoDataFile($id): string
{
    $path = getNeoDataPath($id);
    $content = file_get_contents($path);

    return decrypt($content);
}
