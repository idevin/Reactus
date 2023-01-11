<?php

namespace App\Console\Commands;

use App\Models\BlogSite;
use App\Models\Domain;
use App\Models\DomainVolume;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;

class SyncBlogDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:sync-blog-domains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Blog domains for users';

    /**
     * Execute the console command.
     *
     * @return boolean
     * @throws Exception
     */
    public function handle(): bool
    {
        $users = User::all();
        if (count($users) > 0) {
            foreach ($users as $user) {
                $domainParts = preg_split('#\.#', $user->domain, 2);
                $domain = last($domainParts);

                $domain = Domain::whereName($domain)->first();
                if ($domain) {
                    $blogSite = BlogSite::query()->whereUserId($user->id)->first();

                    if (!$blogSite) {
                        $pvc = DomainVolume::createPvc();
                        BlogSite::firstOrCreate([
                            'user_id' => $user->id,
                            'domain' => $user->domain,
                            'domain_id' => $domain->id,
                            'domain_volume_id' => $pvc->id
                        ]);
                    }
                }
            }
        }

        return true;
    }
}