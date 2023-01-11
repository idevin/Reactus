<?php

namespace App\Console;

use App\Console\Commands\ArticlesUpdate;
use App\Console\Commands\BillingCommand;
use App\Console\Commands\DomainAvailableCommand;
use App\Console\Commands\ParseMigrationsCommand;
use App\Console\Commands\SessionsIndex;
use App\Console\Commands\SyncBlogDomains;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\InternalDeployFolderCommand::class,
        Commands\FixDomainIdCommand::class,
        Commands\FixNullPreviewHashCommand::class,
        Commands\WebSocketCommand::class,
        Commands\UpdateDomainInfo::class,
        Commands\DeleteFiles::class,
        Commands\UpdateSectionsRating::class,
        Commands\RedisSocial::class,
        Commands\ClearNeo::class,
        DomainAvailableCommand::class,
        BillingCommand::class,
        SyncBlogDomains::class,
        SessionsIndex::class,
        ParseMigrationsCommand::class,
        ArticlesUpdate::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('domain:update-info')->daily()->withoutOverlapping();
        $schedule->command('domain:delete-files')->hourly()->withoutOverlapping();
        $schedule->command('domain:check-available')->daily()->withoutOverlapping();

        $schedule->command('bills')->everyMinute()
            ->withoutOverlapping()
            ->sendOutputTo(app_path('../storage/logs/laravel.log'), true);
    }
}
