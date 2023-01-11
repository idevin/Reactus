<?php

namespace App\Traits;

trait Menu
{
    /**
     * @param $data
     * @param array $except
     * @param array $customErrors
     * @param array $customMessages
     * @return mixed
     */
    public static function createMenuValidator($data, array $except = [], array $customErrors = [],
                                               array $customMessages = []): mixed
    {
        return self::createMenuValidator($data, $except, $customErrors, $customMessages);
    }

    public function deleteUrl(string $url)
    {
        if (!$url) {
            return $this->error('Такой URL не найден');
        }

        $this->setIsSystem(false);
        $this->setParams($url->toArray());
        $this->createActivity();

        $urlArray = $url->toArray();

        $url->delete();

        return $urlArray;
    }
}