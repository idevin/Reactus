<?php namespace App\Cacher\Classes\Base;

/**
 * Trait Cacheble
 * @package App\Cacher\Classes\Base
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
trait Cacheble
{
    abstract public function cached(): array;

    public function getCacheData(): array
    {
        $arColumnList = static::cached();
        $arData = [];

        foreach ($arColumnList as $sColumn) {
            try {
                $data = $this->$sColumn;
            } catch (\Exception $exception) {
                continue;
            };

            $arData[$sColumn] = $data;
        }

        return $arData;
    }
}