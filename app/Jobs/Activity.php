<?php

namespace App\Jobs;

use App\Models\Activity as ActivityModel;
use App\Traits\Activity as ActivityTrait;
use App\Traits\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class Activity extends Job implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, ActivityTrait;

    public $data = null;
    public $documentRoot = null;

    /**
     * Create a new job instance.
     * @param array|null $data
     * @param $documentRoot
     */
    public function __construct(array $data, string $documentRoot)
    {
        $this->data = $data;
        $this->documentRoot = $documentRoot;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (env('APP_DEBUG_VARS') == true) {
            debugvars('Activity added: ' . $this->data['title']);
        }
        Media::$documentRoot = $this->documentRoot;

        ActivityModel::create($this->data);
    }
}
