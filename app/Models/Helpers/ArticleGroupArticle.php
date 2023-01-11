<?php


namespace App\Models\Helpers;

use Illuminate\Support\Collection;

class ArticleGroupArticle extends Model
{
    protected static $collection;
    protected static string $collectionClassname = 'App\Models\ArticleGroupArticle';

    public static function setArticleGroupArticles($articleGroupArticles)
    {
        self::setCollection($articleGroupArticles);
    }

    public static function getArticleGroupArticles(): Collection
    {
        return self::getCollection();
    }

}