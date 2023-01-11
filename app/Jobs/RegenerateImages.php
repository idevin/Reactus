<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Model;
use App\Traits\Media;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegenerateImages extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Media;

    public $model = null;

    /**
     * Create a new job instance.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
