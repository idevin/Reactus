<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDomainInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:update-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление данных о домене';

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
    }
}


