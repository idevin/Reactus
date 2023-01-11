<?php

namespace App\Models;

use App\Traits\Utils;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Models\UserSession
 *
 * @property int $id
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array $browser
 * @property string $domain
 * @property string $ip
 * @property int $status
 * @property array $location
 * @property-read mixed $created_at_formated
 * @property-read \App\Models\User|null $user
 * @method static Builder|\App\Models\UserSession newModelQuery()
 * @method static Builder|\App\Models\UserSession newQuery()
 * @method static Builder|\App\Models\UserSession query()
 * @method static Builder|\App\Models\UserSession whereBrowser($value)
 * @method static Builder|\App\Models\UserSession whereCreatedAt($value)
 * @method static Builder|\App\Models\UserSession whereDomain($value)
 * @method static Builder|\App\Models\UserSession whereId($value)
 * @method static Builder|\App\Models\UserSession whereIp($value)
 * @method static Builder|\App\Models\UserSession whereLocation($value)
 * @method static Builder|\App\Models\UserSession whereStatus($value)
 * @method static Builder|\App\Models\UserSession whereUpdatedAt($value)
 * @method static Builder|\App\Models\UserSession whereUserId($value)
 * @mixin Eloquent
 * @property string|null $oc
 * @property string|null $browser_string
 * @property string|null $device_string
 * @property string|null $location_string
 * @property string|null $country_string
 * @method static Builder|UserSession browsers($userId)
 * @method static Builder|UserSession countries($userId)
 * @method static Builder|UserSession devices($userId)
 * @method static Builder|UserSession oc($userId)
 * @method static Builder|UserSession whereBrowserString($value)
 * @method static Builder|UserSession whereCountryString($value)
 * @method static Builder|UserSession whereDeviceString($value)
 * @method static Builder|UserSession whereLocationString($value)
 * @method static Builder|UserSession whereOc($value)
 */
class UserSession extends Model
{
    use Utils;

    const STATUS_LOGGED = 0;
    const STATUS_BLOCKED = 1;
    const STATUS_LOGGED_OUT = 2;
    const STATUS_TRY = 3;
    const STATUSES = [
        self::STATUS_BLOCKED => 'Заблокирован',
        self::STATUS_LOGGED => 'Логин',
        self::STATUS_LOGGED_OUT => 'Выход',
        self::STATUS_TRY => 'Попытка входа'
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

    public $timestamps = true;
    public $appends = [
        'created_at_formated'
    ];
    protected $table = 'user_session';
    protected $fillable = ['user_id', 'browser', 'domain', 'ip', 'status', 'location',
        'device_string', 'browser_string', 'oc', 'location_string', 'country_string'];
    protected $connection = 'mysqlu';
    protected $casts = [
        'browser' => 'json',
        'location' => 'json'
    ];

    public static function blocked($user)
    {
        self::createRecord($user, self::STATUS_BLOCKED);
    }

    public static function createRecord($user, $status)
    {
        $browser = get_browser(null, true);
        $location = json_decode(geo(), true);

        $browserBits = null;
        $platformBits = null;

        if ($browser) {
            if (isset($browser['browser_bits'])) {
                $browserBits = $browser['browser_bits'];
            }

            if (isset($browser['platform_bits'])) {
                $platformBits = $browser['platform_bits'];
            }
        }

        self::query()->create([
            'user_id' => $user->id,
            'browser' => $browser,
            'domain' => env('DOMAIN'),
            'ip' => self::getIp(),
            'status' => $status,
            'location' => geo(),
            'oc' => $browser ? ($browser['platform'] . $platformBits) : null,
            'browser_string' => $browser ? ($browser['browser'] . $browserBits) : null,
            'device_string' => $browser ? $browser['device_type'] : null,
            'location_string' => $location ? $location['iso_code'] : null,
            'country_string' => $location ? $location['country'] : null
        ]);
    }

    public static function logged($user)
    {
        self::createRecord($user, self::STATUS_LOGGED);
    }

    public static function loggedOut($user)
    {
        self::createRecord($user, self::STATUS_LOGGED_OUT);
    }

    public static function try($user)
    {
        self::createRecord($user, self::STATUS_TRY);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->created_at);
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
