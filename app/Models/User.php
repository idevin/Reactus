<?php

namespace App\Models;

use App\Traits\HasRoles;
use App\Traits\Media;
use App\Traits\Response;
use App\Traits\Triggers;
use Auth;
use Eloquent;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Request;
use Schema;

/**
 * Class User
 *
 * @package App\Models
 * @property bool $superadmin
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @method BelongsToMany roles();
 * @property int $id
 * @property string $username
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $phone_work
 * @property string|null $phone_home
 * @property string $auth_token
 * @property string $domain
 * @property string $password
 * @property int $active
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $birthday
 * @property int|null $native_city_id
 * @property int|null $marital_status_id
 * @property int|null $work_place_id
 * @property int|null $address_id
 * @property string|null $website
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $middle_name
 * @property string|null $sex 0-Мужской, 1-Женский
 * @property string|null $password_new
 * @property int|null $visibility
 * @property UserStatus $status
 * @property int|null $parent_id
 * @property int $rating
 * @property string|null $image
 * @property int $locked
 * @property string|null $last_login
 * @property string|null $last_logout
 * @property int|null $user_status_id
 * @property int|null $language_id
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property string|null $trial_ends_at
 * @property float $balance
 * @property int $autorenew
 * @property-read \Illuminate\Database\Eloquent\Collection|Activity[] $activities
 * @property-read Address $address
 * @property-read Comment $article
 * @property-read \Illuminate\Database\Eloquent\Collection|Article[] $articles
 * @property-read City $city
 * @property-read \Illuminate\Database\Eloquent\Collection|Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|Complain[] $complains
 * @property-read \Illuminate\Database\Eloquent\Collection|Complain[] $complainsOnUser
 * @property-read Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|Domain[] $domains
 * @property-read \Illuminate\Database\Eloquent\Collection|StorageFile[] $files
 * @property-read mixed $background
 * @property-read mixed $created_at_formated
 * @property-read mixed $last_login_formated
 * @property-read mixed $last_logout_formated
 * @property-read mixed $profile_url
 * @property-read mixed $referer
 * @property-read mixed $thumbs
 * @property-read mixed $title
 * @property-read Language|null $language
 * @property-read MaritalStatus|null $marital_status
 * @property-read \Illuminate\Database\Eloquent\Collection|Complain[] $moderators
 * @property-read NativeCity|null $native_city
 * @property-read \Illuminate\Database\Eloquent\Collection|News[] $news
 * @property-read \Illuminate\Database\Eloquent\Collection|UserOrder[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $passwordHistories
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $passwordResets
 * @property-read \Illuminate\Database\Eloquent\Collection|Order[] $productOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|Rating[] $ratings
 * @property-read Region $region
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|SectionRole[] $sectionRoles
 * @property-read \Baum\Extensions\Eloquent\Collection|Section[] $sections
 * @property-read Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection|SiteUser[] $siteUsers
 * @property-read \Baum\Extensions\Eloquent\Collection|Site[] $sites
 * @property-read \Illuminate\Database\Eloquent\Collection|UserStatus[] $statuses
 * @property-read \Illuminate\Database\Eloquent\Collection|UserStorageImage[] $storageImages
 * @property-read \Illuminate\Database\Eloquent\Collection|SubscribeUser[] $subscribedUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|WorkPlace[] $work_place
 * @method static Builder|User active()
 * @method static Builder|User login()
 * @method static Builder|User logout()
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User public ()
 * @method static Builder|User query()
 * @method static Builder|User role($roles)
 * @method static Builder|User whereActive($value)
 * @method static Builder|User whereAddressId($value)
 * @method static Builder|User whereAuthToken($value)
 * @method static Builder|User whereAutorenew($value)
 * @method static Builder|User whereBalance($value)
 * @method static Builder|User whereBirthday($value)
 * @method static Builder|User whereCardBrand($value)
 * @method static Builder|User whereCardLastFour($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDomain($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereImage($value)
 * @method static Builder|User whereLanguageId($value)
 * @method static Builder|User whereLastLogin($value)
 * @method static Builder|User whereLastLogout($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereLocked($value)
 * @method static Builder|User whereMaritalStatusId($value)
 * @method static Builder|User whereMiddleName($value)
 * @method static Builder|User whereNativeCityId($value)
 * @method static Builder|User whereParentId($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePasswordNew($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePhoneHome($value)
 * @method static Builder|User wherePhoneWork($value)
 * @method static Builder|User whereRating($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereSex($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereSuperadmin($value)
 * @method static Builder|User whereTrialEndsAt($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUserStatusId($value)
 * @method static Builder|User whereUsername($value)
 * @method static Builder|User whereVisibility($value)
 * @method static Builder|User whereWebsite($value)
 * @method static Builder|User whereWorkPlaceId($value)
 * @mixin Eloquent
 * @method static Builder|User whereAdminAccess($value)
 * @property-read int|null $activities_count
 * @property-read int|null $articles_count
 * @property-read int|null $comments_count
 * @property-read int|null $complains_count
 * @property-read int|null $complains_on_user_count
 * @property-read int|null $domains_count
 * @property-read int|null $files_count
 * @property-read int|null $moderators_count
 * @property-read int|null $news_count
 * @property-read int|null $orders_count
 * @property-read int|null $password_histories_count
 * @property-read int|null $password_resets_count
 * @property-read int|null $permissions_count
 * @property-read int|null $product_orders_count
 * @property-read int|null $ratings_count
 * @property-read int|null $roles_count
 * @property-read int|null $section_roles_count
 * @property-read int|null $sections_count
 * @property-read int|null $site_users_count
 * @property-read int|null $sites_count
 * @property-read int|null $statuses_count
 * @property-read int|null $storage_images_count
 * @property-read int|null $subscribed_users_count
 * @property-read int|null $work_place_count
 * @property string|null $last_password_update
 * @property-read mixed $email_hidden
 * @property-read mixed $pass_update_formated
 * @property-read mixed $phone_hidden
 * @method static Builder|User whereLastPasswordUpdate($value)
 * @method static firstOrCreate(array $array)
 * @property int $admin_access
 * @property-read \App\Models\BlogSite|null $blogSite
 * @property-read mixed $image_url
 * @property mixed $images
 * @method static Builder|User public()
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use HasRoles, Authenticatable, Authorizable, CanResetPassword, Media, Triggers;

    public $timestamps = true;

    protected $fillable = [
        'username', 'phone', 'email', 'password', 'domain', 'active', 'first_name',
        'last_name', 'middle_name', 'phone_more', 'country_id', 'region_id',
        'city_id', 'native_city_id', 'marital_status_id', 'work_place_id',
        'address_id', 'website', 'sex', 'password_new', 'visibility', 'birthday',
        'user_status_id', 'parent_id', 'auth_token', 'rating',
        'image', 'locked', 'last_login', 'last_logout', 'language_id', 'balance', 'card_brand',
        'card_last_four', 'trial_ends_at', 'superadmin', 'last_password_update'
    ];

    protected $hidden = [
        'password', 'remember_token', 'superadmin', 'password_new', 'profile_url'
    ];

    protected $appends = ['profile_url', 'thumbs', 'last_login_formated',
        'last_logout_formated', 'created_at_formated', 'referer', 'pass_update_formated', 'phone_hidden', 'email_hidden'];

    protected $table = 'user';
    protected $connection = 'mysqlu';

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function authToken(): string
    {
        return generate_code(128, true);
    }

    public static function syncAllPermissions($user = null): bool
    {
        if (!$user) {
            $users = self::all();
            UserPermission::query()->truncate();
        } else {
            $users = collect([$user]);
        }

        if (count($users) > 0) {
            foreach ($users as $i => $user) {
                $permissions = collect();

                try {
                    UserPermission::whereUserId($user->id)->delete();
                } catch (Exception $e) {
                    if (env('APP_DEBUG_VARS') == true) {
                        debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
                    }
                }

                if (count($user->roles) > 0) {
                    $user->roles->map(function ($role) use (&$permissions) {
                        $permissions = $permissions->merge($role->permissions);
                    });
                }

                $insertArray = self::groupPermissions($permissions, $user);

                $newData = [];
                foreach ($insertArray as $item) {
                    $newData[] = [
                        'user_id' => $item['user_id'],
                        'permission_id' => $item['permission_id'],
                        'own' => $item['own'],
                        'other' => $item['other']
                    ];
                }

                UserPermission::query()->insert($newData);
            }
        }
        return true;
    }

    public static function groupPermissions(Collection $permissions, $user): array
    {
        $insertArray = [];

        $groupedPerms = $permissions->groupBy('id');

        $groupedPerms->map(function ($items, $id) use ($user, &$insertArray) {
            $own = 0;
            $other = 0;

            if (count($items) > 1) {
                foreach ($items as $item) {
                    if ($item['pivot']['own'] == 1) {
                        $own = 1;
                    }
                    if ($item['pivot']['other'] == 1) {
                        $other = 1;
                    }
                }
            } else {
                $own = $items[0]['pivot']['own'];
                $other = $items[0]['pivot']['other'];
            }

            if (!isset($insertArray[$id])) {
                $insertArray[$id] = [
                    'name' => $items[0]['name'],
                    'user_id' => $user->id,
                    'permission_id' => $id,
                    'own' => $own,
                    'other' => $other
                ];
            }
        });

        return array_values($insertArray);
    }

    public static function selectOptions($notUserId = null, $empty = false): array
    {
        $users = User::query()->orderBy('username', 'ASC');

        if ($notUserId) {
            $users = $users->whereNotIn('id', [$notUserId]);
        }

        $users = $users->get();

        if ($empty == true) {
            $userData = [null => 'Выберите пользователя...'];
        } else {
            $userData = [];
        }

        foreach ($users as $user) {
            $userData[$user->id] = username($user) . ' (' . $user->email . ') ';
        }

        return $userData;
    }

    public static function globalCan($permission, $object, $message,
                                     $options = null, $httpCode = 200)
    {
        $response = new class {
            use Response;
        };

        $error = $response->error($message, $options, $httpCode);

        if (Auth::user() && !Auth::user()->can($permission, $object)) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('GLOBAL USER ERROR: ' . $permission);
            }

            return $error;
        }

        if (Auth::guest() && !self::canAnon($permission)) {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('GLOBAL GUEST ERROR: ' . $permission);
            }

            return $error;
        } else {

            if (env('APP_DEBUG_VARS') == true) {
                debugvars('GLOBAL GUEST SUCCESS: ' . $permission);
            }

            return null;
        }

    }

    public function can($abilities, $arguments = []): bool
    {
        if ($this->roles()->count() <= 0) {
            return false;
        }

        $hasPermission = $this->hasPermission($abilities);

        if ($hasPermission) {
            return app(Gate::class)->forUser($this)->check($abilities, $arguments);
        } else {
            return false;
        }
    }


    /**
     * @param $own
     * @param $other
     * @param $ownSite
     * @return bool|null
     * own    other    own_site    result
     *  1    1        0            +
     *  1    0        0            -
     *  0    0        0            -
     *  0    1        1            -
     *  0    1        0            +
     *  1    1        1            +
     *  1    0        1            +
     */
    public static function catchPermission($own, $other, $ownSite)
    {
        if ($own == 1 && $other == 1 && $ownSite == false) {
            return true;
        } elseif ($own == 1 && $other == 1 && $ownSite == true) {
            return true;
        } elseif ($own == 1 && $other == 0 && $ownSite == false) {
            return false;
        } elseif ($own == 1 && $other == 0 && $ownSite == true) {
            return true;
        } elseif ($own == 0 && $other == 1 && $ownSite == true) {
            return false;
        } elseif ($own == 0 && $other == 1 && $ownSite == false) {
            return true;
        } elseif ($own == 0 && $other == 0 && $ownSite == false) {
            return false;
        }

        return null;
    }

    public function getConnection()
    {
        return static::resolveConnection($this->connection);
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(UserStatus::class)->orderBy('id', 'desc');
    }

    public function statuses()
    {
        return $this->hasMany(UserStatus::class)->orderBy('id', 'desc');
    }

    public function article()
    {
        return $this->belongsTo(Comment::class, 'last_comment_author', 'id');
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function passwordHistories(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function passwordResets(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'author_id', 'id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function work_place(): HasMany
    {
        return $this->hasMany(WorkPlace::class);
    }

    public function marital_status(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function city(): BelongsTo
    {
        $this->connection = 'mysql';
        return $this->belongsTo(City::class);
    }

    public function language(): BelongsTo
    {
        $this->connection = 'mysql';
        return $this->belongsTo(Language::class);
    }

    public function native_city(): BelongsTo
    {
        $this->connection = 'mysql';
        return $this->belongsTo(NativeCity::class);
    }

    public function country(): BelongsTo
    {
        $this->connection = 'mysql';
        return $this->belongsTo(Country::class);
    }

    public function region(): BelongsTo
    {
        $this->connection = 'mysql';
        return $this->belongsTo(Region::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(StorageFile::class);
    }

    public function complains(): HasMany
    {
        return $this->hasMany(Complain::class);
    }

    public function sectionRoles(): HasMany
    {
        $this->setConnection('mysql');
        return $this->hasMany(SectionRole::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(UserOrder::class);
    }

    public function siteUsers(): HasMany
    {
        $this->connection = 'mysql';
        return $this->hasMany(SiteUser::class);
    }

    public function subscribedUsers(): HasMany
    {
        return $this->hasMany(SubscribeUser::class, 'subscribed_user_id');
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function complainsOnUser(): HasMany
    {
        return $this->hasMany(Complain::class, 'on_user_id', 'user_id');
    }

    public function moderators(): HasMany
    {
        return $this->hasMany(Complain::class, 'moderator_id', 'id');
    }

    public function getProfileUrlAttribute(): string
    {
        return route_to_public_profile($this);
    }

    public function getThumbsAttribute(): array
    {
        $image = $this->getImage(UserStorageImage::IMAGE);
        $thumbs = [];

        if (empty($image) && $this->image) {
            foreach (config('image.thumb.avatar') as $item) {
                $width = $item['size'][0];
                $height = $item['size'][1];
                $size = "{$width}x{$height}";
                $thumbs["thumb{$size}"] = $this->imageUrl($size, 'avatar');
            }

            $thumbs["original"] = $this->originalImageUrl('avatar', $this->image, $this);
            $allData = [
                    'id' => null,
                    'title' => '',
                    'description' => '',
                ] + $thumbs;

        } else {
            $image["thumbs"]["original"] = $image['url'];
            $allData = [
                    'id' => $image['id'],
                    'title' => $image['title'],
                    'description' => $image['description'],
                    'url' => $image['url']
                ] + $image['thumbs'];
        }

        return $allData;
    }

    public function getImage($type): array
    {
        $image = UserStorageImage::whereUserId($this->id)->whereType($type)->first();
        $array = [
            'id' => null,
            'title' => null,
            'description' => null,
            'thumbs' => null,
            'url' => null
        ];
        if ($image && $image->storageFile) {
            $array['id'] = $image->storageFile->id;
            $array['title'] = $image->storageFile->title;
            $array['description'] = $image->storageFile->description;
            $array['thumbs'] = $image->storageFile->thumbs;
            $array['url'] = $image->storageFile->thumbs['original'];
        }

        return $array;
    }

    public function getBackgroundAttribute(): array
    {
        return $this->getImage(UserStorageImage::BACKGROUND);
    }

    public function getUserString(): int
    {
        return $this->id;
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function scopePublic($query)
    {
        $this->excludedColumns = ['id', 'created_at', 'updated_at', 'native_city_id', 'marital_status_id', 'work_place_id'];
        return $query->select(array_diff(Schema::getColumnListing($this->table), $this->excludedColumns));
    }

    public function scopeLogin($query)
    {
        $domain = Domain::where('name', '=', env('DOMAIN'))->get()->first();

        $user = UserSite::where('user_id', '=', $this->id)
            ->where('domain_id', '=', $domain->id)
            ->where('admin', '=', 1)
            ->get()->first();

        if (!$user) {
            UserSite::create([
                'user_id' => $this->id,
                'domain_id' => $domain->id,
                'admin' => 1,
                'logged' => 1
            ]);
        } else {
            $user->update([
                'logged' => 1
            ]);
        }
        return $query;
    }

    public function scopeLogout($query)
    {
        $domain = Domain::where('name', '=', env('DOMAIN'))->get()->first();
        $user = UserSite::where('user_id', '=', $this->id)
            ->where('domain_id', '=', $domain->id)
            ->where('admin', '=', 1)
            ->get()->first();

        if ($user) {
            $user->update([
                'logged' => 0
            ]);
        }

        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function allreadyLogged(): bool
    {
        $domain = Domain::whereName(env('DOMAIN'))->get()->first();

        if (!$domain) {
            return false;
        }

        $user = UserSite::whereUserId($this->id)->whereDomainId($domain->id)
            ->whereAdmin(1)->whereLogged(1)->get()->first();

        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    public function getTitleAttribute(): string
    {
        return $this->username;
    }

    public function trigger($ability, $args = [])
    {
        list($class, $method) = preg_split('#\_#', $ability);

        $method = preg_replace('/[^\d\w\-\_]+/i', '_', $method);

        $class = ucfirst($class);
        $classNamespace = "App\Triggers\\" . $class;

        app($classNamespace)->{$method}($this, $args);
    }

    /**
     * @param $ability
     * @param bool $own
     * @param bool $other
     * @return bool
     */
    public function simpleCan($ability, $own = true, $other = true): bool
    {
        $permission = $this->hasPermission($ability);
        if (empty($permission)) {
            return false;
        }

        if ($own && $permission->own != 1) {
            return false;
        }

        if ($other && $permission->other != 1) {
            return false;
        }

        return true;
    }

    public function hasPermissionAll($permission): bool
    {
        return $this->hasPermissionOwn($permission) || $this->hasPermissionOther($permission);
    }

    public function hasPermissionOwn($permission): bool
    {
        $hasPermission = $this->hasPermission($permission);

        if ($hasPermission) {
            return $hasPermission->own == 1;
        }

        return false;
    }

    public function hasPermissionOther($permission): bool
    {
        $hasPermission = $this->hasPermission($permission);

        if ($hasPermission) {
            return $hasPermission->other == 1;
        }

        return false;
    }

    public function storageImages()
    {
        return $this->hasMany(UserStorageImage::class)->with(['storageFile'])->withTrashed();
    }

    public function getLastLoginFormatedAttribute(): string|null
    {
        return datetime_format($this->last_login);
    }

    public function getLastLogoutFormatedAttribute(): string|null
    {
        return datetime_format($this->last_logout);
    }

    public function getCreatedAtFormatedAttribute(): string|null
    {
        return datetime_format($this->created_at);
    }

    public function getPassUpdateFormatedAttribute(): string|null
    {
        return time_ago($this->last_password_update);
    }

    public function getPhoneHiddenAttribute(): string|null
    {
        $phoneHidden = null;
        if ($this->phone) {
            $phoneHidden = substr($this->phone, 0, 4);
            $phoneLen = strlen($this->phone) - 2;
            $phoneHidden .= str_repeat('*', $phoneLen - 4);
            $phoneHidden .= substr($this->phone, $phoneLen, strlen($this->phone));
        }

        return $phoneHidden;
    }

    public function getEmailHiddenAttribute(): ?string
    {
        $emailHidden = null;

        if ($this->email) {
            list($eName, $eDomain) = preg_split("/@/", $this->email);
            $emailHidden .= $eName[0];
            $emailHidden .= str_repeat("*", strlen($eName) - 2);
            $emailHidden .= $eName[strlen($eName) - 1];
            $emailHidden .= '@' . $eDomain;
        }

        return $emailHidden;
    }

    public function getRefererAttribute()
    {
        $referer = Request::server('HTTP_REFERER');

        if ($referer) {

            $parseRefUrl = parse_url($referer)['host'];
            $parseUrl = parse_url(Request::fullUrl())['host'];

            $refererUrl = isset($parseRefUrl) ? $parseRefUrl : null;
            $url = isset($parseUrl) ? $parseUrl : null;

            if ($url == $refererUrl) {
                return null;
            } else {
                return Request::server('HTTP_REFERER');
            }
        } else {
            return null;
        }
    }

    /**
     * @param $obQuery
     * @param $sDomain
     *
     * @return mixed
     */
    public function scopeWhereDomain($obQuery, $sDomain)
    {
        if (empty($sDomain)) {
            return $obQuery;
        }

        return $obQuery->where('domain', $sDomain);
    }

    public function sites(): HasMany
    {
        $this->setConnection('mysql');
        return $this->hasMany(Site::class);
    }

    public function blogSite(): HasOne
    {
        $this->setConnection('mysql');
        return $this->hasOne(BlogSite::class);
    }

    /**
     * @return HasMany
     */
    public function productOrders(): HasMany
    {
        $this->setConnection('mysql');
        $obRel = $this->hasMany(Order::class, 'user_id', 'id');
        $this->setConnection('mysqlu');
        return $obRel;
    }
}
