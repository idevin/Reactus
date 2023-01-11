<?php

namespace App\Jobs;

use App\Traits\Media;
use App\Traits\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CopyContent extends Job implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels, Site;

    public $sites = [];
    public $documentRoot = null;

    /**
     * Create a new job instance.
     * @param $sites
     * @param $documentRoot
     */
    public function __construct($sites, $documentRoot)
    {
        $this->setSites($sites);
        $this->setDocumentRoot($documentRoot);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Media::$documentRoot = $this->getDocumentRoot();
    }

    /**
     * @return null
     */
    public function getDocumentRoot()
    {
        return $this->documentRoot;
    }

    /**
     * @param null $documentRoot
     */
    public function setDocumentRoot($documentRoot)
    {
        $this->documentRoot = $documentRoot;
    }

    /**
     * @return array
     */
    public function getSites(): array
    {
        return $this->sites;
    }

    /**
     * @param array $sites
     */
    public function setSites(array $sites)
    {
        $this->sites = $sites;
    }
}
