<?php

namespace App\Models;

use App;
use App\Traits\Activity as ActivityTrait;
use Eloquent;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Jenssegers\Mongodb\Eloquent\Model as MongoDb;
use Lang;

/**
 * App\Models\Activity
 *
 * @property int $id
 * @property string $o
 * @property string $from_o
 * @property int $o_id
 * @property int $from_o_id
 * @property int $user_id
 * @property int $from_user_id
 * @property string|null $title
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array|null $params
 * @property int $activity_group_id
 * @property-read \App\Models\User $fromUser
 * @property-read \App\Models\User $user
 * @method static Builder|Activity newModelQuery()
 * @method static Builder|Activity newQuery()
 * @method static Builder|Activity query()
 * @method static Builder|Activity whereActivityGroupId($value)
 * @method static Builder|Activity whereCreatedAt($value)
 * @method static Builder|Activity whereDescription($value)
 * @method static Builder|Activity whereFromO($value)
 * @method static Builder|Activity whereFromOId($value)
 * @method static Builder|Activity whereFromUserId($value)
 * @method static Builder|Activity whereId($value)
 * @method static Builder|Activity whereO($value)
 * @method static Builder|Activity whereOId($value)
 * @method static Builder|Activity whereParams($value)
 * @method static Builder|Activity whereTitle($value)
 * @method static Builder|Activity whereUpdatedAt($value)
 * @method static Builder|Activity whereUserId($value)
 * @mixin Eloquent
 * @property int|null $site_id
 * @property array|null $request
 * @property array|null $env
 * @property array|null $server
 * @property array|null $browser
 * @property string|null $platform
 * @property string|null $browser_string
 * @property string|null $device_type
 * @property string|null $ip
 * @property array|null $location
 * @property string|null $domain
 * @property string|null $location_country
 * @property string|null $location_city
 * @property string|null $location_lat
 * @property string|null $location_lon
 * @property string|null $session_name
 * @property string|null $object_string
 * @property string|null $uri
 * @property int $is_system
 * @property int $is_api
 * @property int $http_status_code
 * @property array|null $error
 * @property-read mixed $full_url
 * @property-read \App\Models\Site|null $site
 * @method static Builder|Activity whereBrowser($value)
 * @method static Builder|Activity whereBrowserString($value)
 * @method static Builder|Activity whereDeviceType($value)
 * @method static Builder|Activity whereDomain($value)
 * @method static Builder|Activity whereEnv($value)
 * @method static Builder|Activity whereError($value)
 * @method static Builder|Activity whereHttpStatusCode($value)
 * @method static Builder|Activity whereIp($value)
 * @method static Builder|Activity whereIsApi($value)
 * @method static Builder|Activity whereIsSystem($value)
 * @method static Builder|Activity whereLocation($value)
 * @method static Builder|Activity whereLocationCity($value)
 * @method static Builder|Activity whereLocationCountry($value)
 * @method static Builder|Activity whereLocationLat($value)
 * @method static Builder|Activity whereLocationLon($value)
 * @method static Builder|Activity whereObjectString($value)
 * @method static Builder|Activity wherePlatform($value)
 * @method static Builder|Activity whereRequest($value)
 * @method static Builder|Activity whereServer($value)
 * @method static Builder|Activity whereSessionName($value)
 * @method static Builder|Activity whereSiteId($value)
 * @method static Builder|Activity whereUri($value)
 * @property string|null $date_only
 * @property string $is_content
 * @property-read Collection|\App\Models\ActivityLanguage[] $activityLanguages
 * @property-read int|null $activity_languages_count
 * @property-read mixed $created_at_formatted
 * @property-read mixed $o_translated
 * @property-read mixed $title_translated
 * @method static Builder|\App\Models\Activity personal()
 * @method static Builder|\App\Models\Activity whereDateOnly($value)
 * @method static Builder|\App\Models\Activity whereIsContent($value)
 */
class Activity extends MongoDb
{
    use ActivityTrait;

    protected $collection = 'activity';

    protected $connection = 'mongodb';

    public static array $allowedParams = [
        'HTTP_ACCEPT', 'HTTP_COOKIE', 'REMOTE_ADDR', 'REQUEST_URI', 'SERVER_NAME', 'CONTENT_TYPE', 'HTTP_REFERER',
        'QUERY_STRING', 'HTTP_USER_AGENT', 'HTTP_ACCEPT_LANGUAGE', 'REQUEST_TIME', 'REQUEST_SCHEME'
    ];
    protected $table = 'activity';
    protected $fillable = ['o', 'from_o', 'o_id', 'from_o_id', 'user_id',
        'from_user_id', 'title', 'description', 'params', 'site_id',
        'request', 'env', 'server', 'browser', 'browser_string', 'oc', 'device_string', 'session_name',
        'ip', 'location', 'domain', 'country_string', 'location_city', 'location_lat', 'location_lon',
        'object_string', 'uri', 'is_api', 'is_system', 'http_status_code', 'error', 'date_only'
    ];
    protected $casts = [
        'params' => 'json',
        'request' => 'json',
        'env' => 'json',
        'server' => 'json',
        'browser' => 'json',
        'location' => 'json',
        'error' => 'json'
    ];
    protected $appends = [
        'full_url', 'title_translated', 'created_at_formatted', 'o_translated'
    ];

    const SORTBY_ORDER = [
        'asc', 'desc'
    ];

    const SORT_OPTIONS = [
        'status' => 'Статус',
        'browser_string' => 'Сессия',
        'device_string' => 'Девайс',
        'location_string' => 'Страна',
        'domain' => 'Домен',
        'created_at' => 'Дата',
        'oc' => 'Операционная система'
    ];

    const DEFAULT_LIMIT = 10;

    public static function params($data = null)
    {
        $allowed = [];
        if ($data && is_array($data)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, self::$allowedParams)) {
                    unset($data[$key]);
                } else {
                    $allowed[$key] = $value;
                }
            }
        }

        return $allowed;
    }

    public function object()
    {
        return App::make($this->o)->find($this->o_id);
    }

    public function fromObject()
    {
        return App::make($this->from_o)->find($this->from_o_id);
    }

    public function user()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class);
    }

    public function site()
    {
        $this->setConnection('mysql');
        return $this->belongsTo(Site::class);
    }

    public function fromUser()
    {
        $this->setConnection('mysqlu');
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function getFullUrlAttribute()
    {
        $url = 'https://';

        if (isset($this->server['REQUEST_SCHEME']) && isset($this->domain)) {
            $url = $this->server['REQUEST_SCHEME'] . '://';
        }

        if (isset($this->domain)) {
            $url .= $this->domain;
        }

        if (isset($this->uri)) {
            $url .= $this->uri;
        }

        if ($url == 'http://') {
            $url = null;
        } else {
            $url = preg_replace('/\?token\=(.*)\&{0,1}/', '', $url);
        }

        return $url;
    }

    public function activityLanguages()
    {
        $this->setConnection('mysql');
        return $this->hasMany(ActivityLanguage::class, 'activity_key', 'title');
    }

    public function scopePersonal($query)
    {
        return $query->whereIsSystem(0);
    }

    public function getTitleTranslatedAttribute()
    {
        $activityByLang = $this->activityLanguages->keyBy('lang');
        $locale = Lang::getLocale();

        if (!empty($activityByLang) && isset($activityByLang[$locale])) {
            return $activityByLang[$locale]->translated;
        }

        return null;
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return $this->created_at->format('d.m.Y H:i');
    }

    public function getOTranslatedAttribute(): array|string|Translator|Application|null
    {
        return __($this->object_string);
    }

    public function scopeOc($query, $userId)
    {
        return $query->groupBy('oc')->whereUserId($userId)->get()->pluck('oc')->toArray();
    }

    public function scopeBrowsers($query, $userId)
    {
        return $query->groupBy('browser_string')->whereUserId($userId)
            ->whereNotNull('browser_string')->get()->pluck('browser_string')->toArray();
    }

    public function scopeDevices($query, $userId)
    {
        return $query->groupBy('device_string')->whereUserId($userId)
            ->whereNotNull('device_string')->get()->pluck('device_string')->toArray();
    }

    public function scopeCountries($query, $userId)
    {
        return $query->groupBy('country_string')->whereUserId($userId)
            ->whereNotNull('country_string')->get()->pluck('country_string')->toArray();
    }

}
