<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:delete-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление мертвых доменов и сайтов';

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


