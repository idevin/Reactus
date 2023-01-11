<?php

namespace App\Console\Commands;

use App\Models\Section;
use Illuminate\Console\Command;

class UpdateSectionsRating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sections:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление разделов';

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
        $sections = Section::all();

        foreach ($sections as $section) {
            $rating = Section::calculateRating($section);

            $section->update([
                'rating' => rating_format($rating)
            ]);
        }

        return;
    }
}