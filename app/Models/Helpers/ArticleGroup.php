<?php


namespace App\Models\Helpers;

class ArticleGroup extends Model
{
    protected static $collection;
    protected static string $collectionClassname = 'App\Models\ArticleGroup';

    public static function getArticleGroups()
    {
        self::getCollection();
    }

    public static function setArticleGroups($articleGroups)
    {
        self::setCollection(collect($articleGroups));
    }

    public static function getArticleGroupByKey($key, $id)
    {
        return self::getCollection()->where($key, $id);
    }

    public static function getByArticleId($articleId)
    {
        return self::getWhere('article_id', $articleId);
    }

}