<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Article;

class FixNullPreviewHashCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:preview-hash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix nulled article preview_hash';

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
        foreach ((new \App\Models\Article)->whereNull('preview_hash')->get() as $entity) {

            $this->info('Article #' . $entity->id . ':');

            $entity->preview_hash = generate_code(16);
            $entity->save();

            $this->info('Fixed article #' . $entity->id);
        }

        $this->info('Task completed.');
    }
}
