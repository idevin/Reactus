<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\Site;
use Illuminate\Console\Command;

class FixDomainIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:domain-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix relation One to Many. Domain has many sites';

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
     * @return mixed
     */
    public function handle()
    {
        $sites = Site::all();

        $bar = $this->output->createProgressBar(count($sites));

        foreach ($sites as $site) {

            $mainDomain = main_domain(idnToAscii($site->domain));

            $domain = Domain::where('name', $mainDomain)->get()->first();

            if (!$domain) {
                $this->error('Domain not found:  ' . $mainDomain . '');
                continue;
            }

            $site->domain_id = $domain->id;
            $site->save();

            $bar->advance();
        }

        $bar->finish();
    }
}
