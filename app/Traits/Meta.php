<?php

namespace App\Traits;

use App\Models\Site;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

trait Meta
{
    public function getMeta($method, ...$args)
    {
        $classInfo = preg_split('#::#', $method);
        $controller = lcfirst(last(preg_split('#\\\#', $classInfo[0])));
        $method = ucfirst($classInfo[1]);
        $this->{$controller . $method}($args);
    }

    public function articleControllerIndex($args)
    {
        $this->homeControllerIndex($args);
    }

    public function homeControllerIndex($args)
    {
        $site = $args[0];
        if ($site) {
            $logo = $site->originalLogo();
            $image = null;

            if ($site->setting) {
                $title = $site->setting->seo_title;
                $description = $site->setting->seo_description;
            } else {
                $title = $site->title;
                $description = strip_tags($site->content);
            }

            if ($logo && isset($logo['url'])) {
                $image = $site->url . $logo['url'];
            }

            self::meta($title, null, $description, $image);
        }
    }

    public static function meta($title = null, $keywords = null, $description = null, $image = null, $url = null)
    {
        $site = get_site();

        if (!$site) {
            return null;
        }

        if (!$title) {
            $title = $site->title;
        }

        view()->share('title', $title);

        if ($keywords) {
            view()->share('keywords', $keywords);
        }

        if ($description) {
            view()->share('description', $description);
        }

        if (!$image && get_class($site) == Site::class) {
            $logo = $site->originalLogo();
            if ($logo && isset($logo['url'])) {
                $image = $site->url . $logo['url'];
            }
        }

        view()->share('image', $image);

        if (!$url) {
            $url = $site->url;
        }

        view()->share('url', $url);
    }

    public function articleControllerArticle($args)
    {

    }

    public function articleControllerShow($args)
    {
        $responseData = $args[0]->getData();
        $article = null;

        if ($responseData && $responseData->data) {
            $article = $responseData->data->article;
        }

        if ($article) {

            $defaultMeta = self::defaultMeta($article);

            if (!empty($article->thumbs)) {
                $image = get_site()->url . $article->thumbs->thumb1920x1080;
            } else {
                $image = null;
            }

            $url = route_to_article($article);

            self::meta($defaultMeta['title'], null, $defaultMeta['description'], $image, $url);
        } else {
            self::meta();
        }
    }

    #[ArrayShape(['title' => "mixed", 'description' => "mixed"])] #[Pure]
    public static function defaultMeta($o): array
    {
        $data = self::getTitleDescription($o);

        return ['title' => $data['title'], 'description' => $data['description']];
    }

    public static function getTitleDescription($o): array
    {

        $title = null;

        if (!empty($o->title)) {
            $title = $o->title;
        } elseif (!empty($o->name)) {
            $title = $o->name;
        }
        $title = strip_tags($title);

        $description = !empty($o->content_short) ? strip_tags($o->content_short) : null;

        if ($o->seo_title) {
            $title = strip_tags($o->seo_title);
        }
        if ($o->seo_description) {
            $description = strip_tags($o->seo_description);
        }

        return compact('title', 'description');
    }

    public function sectionControllerShow($args)
    {
        $this->sectionControllerIndex($args);
    }

    public function sectionControllerIndex($args)
    {
        $section = $args[0];

        if ($section) {
            $defaultMeta = self::defaultMeta($section);

            if (!empty($section->thumbs)) {
                $image = get_site()->url . $section->thumbs['thumb1920x1080'];
            } else {
                $image = null;
            }

            $url = route_to_section($section);

            self::meta($defaultMeta['title'], null, $defaultMeta['description'], $image, $url);
        } else {
            self::meta();
        }
    }

    public function objectsControllerCard($args)
    {
        $card = $args[0];

        $image = null;

        $data = self::getTitleDescription($card);

        $card::$absolute = true;
        $url = $card->url;

        self::meta($data['title'], null, $data['description'], $image, $url);
    }

    /**
     * @param $args
     */
    public function handlerRender($args)
    {
        self::meta();
    }
}