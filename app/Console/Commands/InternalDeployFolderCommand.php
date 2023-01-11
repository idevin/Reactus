<?php

namespace App\Console\Commands;

use App\Helpers\Deployer\Classes\Deployer;
use App\Models\BlogSite;
use App\Models\Domain;
use App\Models\User;
use App\Models\UserSite;
use App\Traits\Domain as DomainTrait;
use App\Traits\Site;
use App\Utils\DomainInstaller;
use Illuminate\Console\Command;

class InternalDeployFolderCommand extends Command
{
    use Site;
    use DomainTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'internal-deploy {on?} {--no-restart} {--no-ssl-cert}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy pods';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     * @throws \Exception
     */
    public function handle(): bool
    {

        $excluded = preg_split('/@/', env('EXCLUDED_DOMAINS'));

        $domains = Domain::query()->whereNotIn('name', $excluded)->get();

        foreach ($domains as $domain) {

            $env = 'development';

            if ($domain->environment == 1) {
                $env = 'production';
            }

            $customerDomain = '';
            $domainName = $domain->name;

            if ($domain->is_customer_domain == 1) {
                $customerDomain = $domain->name;
                $domainName = $domain->parent->name;
            }

            (new Deployer($domainName, $domain->domainVolume, false, $customerDomain))->v1();

            $info = $domain->name . ' installed. [' . $env . ']';

            $this->info($info);
        }

        $users = User::query()->orderBy('domain')->get();

        if (count($users) > 0) {
            foreach ($users as $user) {
                $site = BlogSite::query()->where('domain', $user->domain)->first();
                if ($site) {
                    $this->info('Starting installation of ' . $user->domain . ' for user ' . $user->username . ' with ' . $site->DomainVolume . ' PVC.');

                    (new Deployer($user->domain, $site->domainVolume, true))->v1();

                    $this->info('Domain ' . $user->domain . ' installed.');
                }
            }
        }

        return 0;
    }

    public function clearLoggedUsers()
    {
        UserSite::query()->truncate();
    }
}
