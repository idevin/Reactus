<?php namespace App\Cacher\Classes\Base;

use App\Models\Model;
use Illuminate\Support\Facades\Cache;
use Prophecy\Exception\Doubler\MethodNotFoundException;
use Sebwite\Support\Traits\Extendable;

/**
 * Class BaseItem
 * @package App\Cache\Classes\Base
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
abstract class BaseItem
{
    /**
     * @var int $iElementID
     */
    private $iElementID;

    /**
     * @var array $arCachedData
     */
    private $arCachedData = [];

    public function __construct($iElementID)
    {
        $this->iElementID = $iElementID;
    }

    private $arHidden = [];

    /**
     * @param int $iElementID
     *
     * @return array|mixed
     */
    public static function make($iElementID)
    {
        $arParamList = [
            'iElementID' => $iElementID,
        ];

        $sModelClass = static::getModelClass();

        $arItemData = Cache::get(static::cacheTag().$iElementID);
        if (!empty($arItemData)) {
            /** @var BaseItem $obItem */
            $obItem = app()->make(static::class, $arParamList);
            $obItem->setCacheData(json_decode($arItemData, true));
            return $obItem;
        }

        /** @var BaseItem $obItem */
        $obItem = app()->make(static::class, $arParamList);

        /** @var Model|Cacheble $obModel */
        $obModel = static::getElement($sModelClass, $iElementID);
        if (empty($obModel) || !method_exists($obModel, 'getCacheData')) {
            return $obItem;
        }

        $arModelCacheData = $obModel->getCacheData();
        if (empty($arModelCacheData)) {
            return $obItem;
        }

        $obItem->setCacheData($arModelCacheData);
        Cache::forever(static::cacheTag().$iElementID, json_encode($arModelCacheData));

        return $obItem;
    }

    public static function clearCache($iElementID)
    {
        if (empty($iElementID)) {
            return;
        }

        Cache::forget(static::cacheTag().$iElementID);
    }

    abstract public static function getModelClass() : string;

    abstract protected static function getElement(string $sModelClass, $iElementID);

    public static function cacheTag() : string
    {
        return static::class;
    }

    protected function setCacheData($arData = [])
    {
        $this->arCachedData = $arData;
    }

    public function __get($sName)
    {
       $sCallName = $this->getCallbackName($sName);
        if (method_exists($this, $sCallName)) {
            return $this->$sCallName();
        }

        if (isset($this->arCachedData[$sName])) {
            return $this->arCachedData[$sName];
        }

        return null;
    }

    public function __set($sName, $anthValue)
    {
        if (!isset($this->arCachedData[$sName])) {
            return null;
        }

        $this->arCachedData[$sName] = $anthValue;
    }

    public function __call($sName, $arArguments)
    {
        if (method_exists($this, $sName)) {
            $this->$sName(...$arArguments);
        }

        throw new \App\Cacher\Classes\Base\MethodNotFoundException('Method '.$sName.' not found in '. static::class.' class');
    }

    public function isEmpty() : bool
    {
        return empty($this->arCachedData);
    }

    public function isNotEmpty() : bool
    {
        return !$this->isEmpty();
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $arResult = [];

        foreach ($this->arCachedData as $sKey => $sProp) {
            if (in_array($sKey, array_keys($this->arHidden))) {
                continue;
            }

            $sCallName = $this->getCallbackName($sKey);
            if (method_exists($this, $sCallName) && !isset($this->arCachedData[$sKey])) {
                $arResult[$sKey] = $this->$sCallName();
                continue;
            }

            $arResult[$sKey] = $sProp;
        }

        return $arResult;
    }

    public function getAttribute($sAttrName)
    {
        if (in_array($sAttrName, array_keys($this->arHidden))) {
            return null;
        }

        return isset($this->arCachedData[$sAttrName]) ? $this->arCachedData[$sAttrName] : null;
    }


    /**
     * @param array $arHiddenProp
     *
     * @return BaseItem
     */
    public function makeHidden($arHiddenProp = []) : self
    {
        foreach ($arHiddenProp as $sHiddenProp) {
            if (!is_string($sHiddenProp)) {
                continue;
            }

            if (!in_array($sHiddenProp, array_keys($this->arCachedData))) {
                continue;
            }

            $this->arHidden[$sHiddenProp] = true;
        }

        return $this;
    }

    /**
     * @param string $sCall
     *
     * @return string
     */
    private function getCallbackName($sCall) : string
    {
        $arStrings = explode('_', $sCall);
        $sParamName = '';

        foreach ($arStrings as $sString) {
            $sParamName .= ucfirst($sString);
        }

        return 'get'.$sParamName.'Attribute';
    }

    public function __sleep()
    {
        $arResult = $this->toArray();

        return json_encode($arResult);
    }

    public function setAttribute($sAttrName, $anAttrValue)
    {
        $this->arCachedData[$sAttrName] = $anAttrValue;
    }

    public function with($arAttributeNames)
    {
        if (!is_array($arAttributeNames)) {
            if (!is_string($arAttributeNames)) {
                return;
            }

            $this->arCachedData[$arAttributeNames] = null;
            return;
        }

        foreach ($arAttributeNames as $sAttrName) {
            $this->arCachedData[$sAttrName] = null;
        }

        return $this;
    }
}