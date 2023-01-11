<?php

namespace App\Providers;

use App\Events\OrderEvent;
use App\Events\UserRegisteredEvent;
use App\Listeners\OrderListener;
use App\Listeners\UserEventListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use JhaoDa\SocialiteProviders\MailRu\MailRuExtendSocialite;
use JhaoDa\SocialiteProviders\Odnoklassniki\OdnoklassnikiExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegisteredEvent::class => [
            UserEventListener::class
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\VKontakte\VKontakteExtendSocialite@handle',
            'SocialiteProviders\Google\GoogleExtendSocialite@handle',
            OdnoklassnikiExtendSocialite::class,
            'SocialiteProviders\Instagram\InstagramExtendSocialite@handle',
            'SocialiteProviders\Yandex\YandexExtendSocialite@handle',
            'SocialiteProviders\LinkedIn\LinkedInExtendSocialite@handle',
            MailRuExtendSocialite::class
        ],
        OrderEvent::class => [
            OrderListener::class,
        ],
    ];

    /**
     * Register any other events for your application.
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
