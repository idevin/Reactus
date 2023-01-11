<?php

namespace App\Console\Commands;

use App\Models\Article as ArticleModel;
use App\Traits\Article;
use Illuminate\Console\Command;

class ArticlesUpdate extends Command
{

    use Article;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aticles updater';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {

        $articles = ArticleModel::query()->whereNotNull('unpublished_at')
            ->whereStatus(ArticleModel::STATUS_DRAFT_OFF)->whereDraft(ArticleModel::STATUS_DRAFT_OFF);

        $this->updateUnpublishedArticles($articles, ArticleModel::class);

        return 0;
    }
}
