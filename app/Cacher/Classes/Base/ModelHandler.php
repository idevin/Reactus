<?php namespace App\Cacher\Classes\Base;

use App\Models\Model;

/**
 * Class ModelHandler
 * @package App\Cacher\Classes\Base
 * @author  Ilya Beltyukov, 968597@gmail.com
 */
abstract class ModelHandler
{
    abstract public function getItemClass() : string;

    protected $sDefaultColumn = 'id';

    /**
     * @var Model $obElement
     */
    protected $obElement = null;

    /**
     * @param Model $obModel
     */
    public function created($obModel)
    {
        $this->obElement = $obModel;
        $this->afterCreate();
    }

    /**
     * @param Model $obModel
     */
    public function updated($obModel)
    {
        $this->obElement = $obModel;
        $this->clearItemCache();
        $this->afterUpdate();
    }

    /**
     * @param Model $obModel
     */
    protected function deleted($obModel)
    {
        $this->obElement = $obModel;
        $this->clearItemCache();
        $this->afterDelete();
    }

    protected function afterCreate()
    {
    }

    protected function afterUpdate()
    {
    }

    protected function afterDelete()
    {
    }

    protected function clearItemCache()
    {
        /** @var BaseItem $sItemClass */
        $sItemClass = static::getItemClass();
        $sField = $this->sDefaultColumn;

        $sItemClass::clearCache($this->obElement->$sField);
    }

    protected function isFieldChange($sField) : bool
    {
        return $this->obElement->$sField != $this->obElement->getOriginal($sField);
    }
}