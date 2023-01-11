<?php

namespace App\Traits;


use App\Models\Domain;
use Exception;
use Intervention\Image\ImageManagerStatic;
use Ixudra\Curl\CurlService;
use Validator;

trait CustomValidators
{

    public static array $urls = [
        'facebook' => ['fb.com', 'facebook.com', 'fb.me'],
        'vk' => ['vk.com', 'vkontakte.ru', 'vk.cc'],
        'instagram' => ['instagram.com', 'instagr.am'],
        'ok' => ['ok.ru', 'odnoklassniki.ru', 'ok.me'],
        'twitter' => ['twitter.com', 't.co']
    ];

    public static function siteSectionUsersValidator($rules, $data)
    {
        $messages = [
            'user_id.required' => 'Выберите пользователя',
            'role_id.required' => 'Выберите роли для пользователя'
        ];

        if (empty($data['role_id'])) {
            $rules['role_id'] = 'required';
            $messages['role_id.required'] = 'Выберите роли для пользователя';
        }

        if (!empty($data['user_id'])) {
            $rules['user_id'] = 'required';
            $messages['user_id.required'] = 'Выберите пользователя';
        }

        return Validator::make($data, $rules, $messages);
    }

    protected function customValidators()
    {
        if (php_sapi_name() !== 'cli') {
            Validator::extend('domain', function ($attr, $value, $params, $validator) {

                $domains = Domain::thematic()->get()->pluck('name');

                return $domains->contains(main_domain($value));
            });

            Validator::extend('our_domain', function ($attr, $value, $params, $validator) {
                $url = parse_url($value);

                if (!isset($url['host'])) {
                    $url['host'] = env('DOMAIN');
                }

                if (!isset($url['scheme'])) {
                    $url['scheme'] = 'http';
                }

                $host = $url['host'];
                $scheme = $url['scheme'];

                $domains = Domain::all()->pluck('name');

                if (!$domains->contains($host)) {
                    return false;
                }

                $domain = $scheme . '://' . $host;

                $response = (new CurlService())->to($domain)->withData(['na' => 1])
                    ->returnResponseObject()->allowRedirect()->get();

                if ($response->status !== 200) {
                    return false;
                }

                return true;
            });

            Validator::extend('base64', function ($attribute, $value, $params, $validator) {

                try {
                    ImageManagerStatic::make($value);
                    return true;
                } catch (Exception $e) {
                    if (env('APP_DEBUG_VARS') == true) {
                        debugvars($e->getTraceAsString());
                    }
                    return false;
                }
            });

            Validator::extend('phone', function ($attribute, $value, $params, $validator) {
                $result = preg_match(phoneRegexp(), $value);

                if ((int)$result == 1) {
                    return true;
                }

                return false;
            });

            Validator::extend('domain_exists', function ($attribute, $value, $parameters, $validator) {
                $value = idnToAscii($value);
                $domain = Domain::whereName($value)->first();
                return isset($domain);
            });

            Validator::extend('domain_valid', function ($attribute, $value, $parameters, $validator) {
                return $this->domainValid($value);
            });

            Validator::extend('domain_valid_dns', function ($attribute, $value, $parameters, $validator) {

                return valid_dns($value);
            });

            Validator::extend('email_extended', function ($attribute, $value, $params, $validator) {
                $valid = (!empty($value) && filter_var($value, FILTER_VALIDATE_EMAIL));
                $domain = explode('@', $value);

                if (isset($domain[1])) {
                    $domain = idnToAscii($domain[1]) . '.';
                } else {
                    return false;
                }

                return $valid && $domain && checkdnsrr($domain, 'A');
            });

            Validator::extend('clean_whitespace', function ($attribute, $value, $params, $validator) {
                if (!empty($value)) {
                    $value = preg_replace("/\s+/", " ", $value, -1, $count);
                } else {
                    return false;
                }

                return $value;
            });

            Validator::extend('json', function ($attribute, $value, $params, $validator) {
                $valid = null;

                if (!empty($value)) {
                    $valid = json_decode($value, true);
                }

                return $valid;
            });


            self::socialsValidator();
        }
    }

    protected function domainValid($value): bool
    {
        return check_domain_name($value);
    }

    public static function socialsValidator()
    {
        foreach (static::$urls as $alias => $urls) {

            Validator::extend($alias, function ($attribute, $value, $params, $validator) use ($urls) {
                $valid = false;

                foreach ($urls as $url) {
                    if (strstr($value, $url) !== false) {
                        $valid = true;
                        break;
                    }
                }
                return $valid;
            });

        }
    }
}