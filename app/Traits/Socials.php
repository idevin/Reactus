<?php

namespace App\Traits;

use App\Helpers\Deployer\Classes\Deployer;
use App\Models\BlogSite;
use App\Models\DomainVolume;
use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use App\Models\UserSocial;
use App\Traits\Domain as DomainTrait;
use Cache;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator as ValidatorClass;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use SocialiteProviders\Manager\Config;

trait Socials
{
    use DomainTrait;

    /**
     * @param $data
     * @param array $except
     * @param array $customErrors
     * @param array $customMessages
     * @return ValidatorClass
     */
    public static function createSocialsValidator($data, $except = [], $customErrors = [],
                                                  $customMessages = []): ValidatorClass
    {
        $default = [
            'module_id' => 'required',
            'module_settings_id' => 'required',
            'facebook_url' => 'sometimes|url',
            'vk_url' => 'sometimes|url',
            'twitter_url' => 'sometimes|url',
            'instagram_url' => 'sometimes|url',
            'ok_url' => 'sometimes|url'
        ];

        $messages = [
            'module_id.required' => 'Не задан ID модуля',
            'module_settings_id.required' => 'Не заданы настройки для блока'
        ];

        $messagesMerged = array_merge($messages, $customMessages);

        $rulesMerged = array_merge($default, $customErrors);
        $rules = collect($rulesMerged)->except($except)->toArray();

        return Validator::make($data, $rules, $messagesMerged);
    }

    public function index()
    {
        $config = $this->getConfig();

        $oConfig = new Config(
            $config['client_id'], $config['client_secret'], $config['redirect']);

        $isOauth = (get_parent_class(Socialite::driver($this->getProvider())) == AbstractProvider::class);

        $oSocialite = Socialite::driver($this->getProvider());

        if (!$isOauth) {
            $oSocialite = $oSocialite->setConfig($oConfig);
        }

        $oSocialite = $oSocialite->scopes($this->getScopes());

        $user = Auth::user();

        if ($user) {
            $user = $user->id;
        }

        $data = json_encode([
            'domain' => env('DOMAIN'),
            'user_id' => $user
        ]);

        $provider = $this->getProvider();

        forget($provider);

        remember($provider, function () use ($data) {
            return $data;
        });

        return $oSocialite->redirect();
    }

    /**
     * @return Application|RedirectResponse|Redirector|string
     * @throws Exception
     */
    public function callback(): string|Redirector|Application|RedirectResponse
    {
        $provider = $this->getProvider();

        $newUser = false;

        $cachedData = Cache::get($provider);
        $cachedData = json_decode($cachedData, true);

        $error = request()->get('error');
        $denied = request()->get('denied');

        $prefix = getSchema();

        if ($error || $denied) {
            return redirect($prefix . $cachedData['domain']);
        }

        $oauthUser = Socialite::driver($provider);

        if (!self::isOauth1($provider)) {
            $oauthUser = $oauthUser->stateless();
        }

        try {
            $oauthUser = $oauthUser->user();
        } catch (Exception $e) {
            debugvars($e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $e->getMessage();
        }

        if (!empty($cachedData['user_id'])) {
            $user = User::whereId($cachedData['user_id'])->first();

            $nickname = self::getNickname($oauthUser);

            $data = [
                'uid' => $oauthUser->getId(),
                'user_id' => $user->id,
                'token' => $oauthUser->token,
                'expires' => $oauthUser->expiresIn ?? 0,
                'email' => $oauthUser->getEmail(),
                'refresh_token' => $oauthUser->refreshToken ?? null,
                'name' => $oauthUser->getName(),
                'nickname' => $nickname,
                'provider' => $provider,
                'first_name' => self::getFirstName($oauthUser),
                'last_name' => self::getLastName($oauthUser)
            ];

            if ($user) {

                $userSocial = UserSocial::getProvider($user->id, $provider);

                if ($userSocial) {
                    $userSocial->update($data);
                } else {
                    UserSocial::create($data);
                }
            }
        } else {

            $nickname = self::getNickname($oauthUser);

            $personalDomain = self::getRandomPersonal();

            $email = $oauthUser->getEmail();

            $user = User::query()->orWhere('username', $nickname);

            if (!empty($email)) {
                $user = $user->orWhere('email', $email);
            }

            $user = $user->first();

            $userData = [
                'username' => $nickname,
                'password' => bcrypt(time()),
                'domain' => $nickname . '.' . $personalDomain->name,
                'last_name' => self::getFirstName($oauthUser),
                'first_name' => self::getLastName($oauthUser),
                'email' => $email,
                'active' => 1,
                'auth_token' => User::authToken(),
                'language_id' => Language::default()->id
            ];

            if (!$user) {
                $user = User::firstOrCreate($userData);
                $blogSite = $user->blogSite;

                if (!$blogSite) {
                    $pvc = DomainVolume::createPvc();
                    $blogSite = BlogSite::firstOrCreate([
                        'user_id' => $user->id,
                        'domain' => $user->domain,
                        'domain_id' => $personalDomain->id,
                        'domain_volume_id' => $pvc->id
                    ]);
                }

                (new Deployer($user->domain, $blogSite->domainVolume, true))->v1();

                $newUser = true;
            }

            $data = [
                'uid' => $oauthUser->getId(),
                'user_id' => $user->id,
                'token' => $oauthUser->token,
                'expires' => $oauthUser->expiresIn ?? 0,
                'email' => $oauthUser->getEmail(),
                'refresh_token' => $oauthUser->refreshToken ?? null,
                'name' => $oauthUser->getName(),
                'nickname' => $nickname,
                'provider' => $provider,
                'last_name' => self::getLastName($oauthUser),
                'first_name' => self::getFirstName($oauthUser)
            ];

            $userSocial = UserSocial::byUid($oauthUser->getId(), $provider);

            $data['user_id'] = $user->id;

            if ($userSocial) {
                $userSocial->update($data);
            } else {
                UserSocial::create($data);
            }
        }

        if ($newUser === true) {

            $roles = Role::whereForRegistered(1)->get();

            if (count($roles) > 0) {
                $user->syncRoles($roles);
            }

            $user->syncAllPermissions($user);
        }

        $cachedData['user_id'] = $user->id;
        remember('social.' . $user->id, function () use ($cachedData) {
            return $cachedData;
        });

        forget($provider);

        return redirect($prefix . $cachedData['domain'] .
            route('home.login', ['id' =>encrypt($user->id, false)], false));
    }

    public static function isOauth1($provider): bool
    {
        return in_array($provider, config('netgamer.oauth1'));
    }

    public static function getNickname($oauthUser): string
    {
        $nickname = $oauthUser->getNickname();
        $email = $oauthUser->getEmail();

        if (!empty($nickname)) {
            return slugify($nickname);

        } elseif (isset($oauthUser->user['login'])) {
            return slugify($oauthUser->user['login']);

        } elseif (!empty($email)) {
            $nickname = preg_split('#@#', $email);
            return slugify($nickname[0]);

        } else {
            return slugify();
        }
    }

    public static function getFirstName($oauthUser)
    {
        $firstName = null;

        if (isset($oauthUser->user['first_name'])) {
            $firstName = $oauthUser->user['first_name'];

        } elseif (isset($oauthUser->user['full_name'])) {

            if (preg_match('/\s/', $oauthUser->user['full_name'])) {
                $firstName = preg_split('/\s/', $oauthUser->user['full_name']);
                $firstName = $firstName[0];
            } else {
                $firstName = $oauthUser->user['full_name'];
            }
        }

        return $firstName;
    }

    public static function getLastName($oauthUser)
    {
        $lastName = null;

        if (isset($oauthUser->user['last_name'])) {
            $lastName = $oauthUser->user['last_name'];
        } elseif (isset($oauthUser->user['full_name'])) {
            if (preg_match('/\s/', $oauthUser->user['full_name'])) {
                $lastName = preg_split('/\s/', $oauthUser->user['full_name']);
                $lastName = $lastName[1];
            } else {
                $lastName = $oauthUser->user['full_name'];
            }
        }

        return $lastName;
    }

    public static function generateAvatar($user)
    {
        if (empty($user->image)) {
            $color = $user->getColor();

            $imageName = Str::random() . '.png';

            $user->generateImage(70, 70, $imageName, $color, 'avatar', $user->nickname);

            $user->update([
                'image' => $imageName,
            ]);
        }
    }
}