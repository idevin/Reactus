<?php


namespace App\Traits;


use App\Models\Article;

trait Searchable
{
    public static function urlArticleControllerShow($options = [])
    {
        if (isset($options['id'])) {
            $article = Article::query()->published()->active()->find((int)$options['id']);
            if ($article) {
                return [
                    'title' => $article->title,
                    'type' => get_class($article),
                    'object' => $article,
                    'id' => $article->id
                ];
            }
        }
        return null;
    }

    public static function urlHomeControllerIndex($options = [])
    {
        return self::urlArticleControllerShow($options);
    }
}