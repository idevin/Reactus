<?php namespace App\Cacher\Classes\Base;

abstract class BaseCollection implements \Iterator
{
    const DEFAULT_COLUMN = 'id';

    private int $iPosition;

    protected array $arIDList = [];

    protected string $sDefaultColumn = "id";

    public function __construct()
    {
        $this->iPosition = 0;
    }

    /**
     * @param array $arIDList
     *
     * @return BaseCollection
     */
    public function intersect($arIDList = []): BaseCollection
    {
        if ($this->isClear()) {
            $this->arIDList = $arIDList;
            return $this->returnThis();
        }

        $this->arIDList = array_intersect($this->arIDList, $arIDList);

        return $this->returnThis();
    }

    /**
     * @param array $arIDList
     *
     * @return BaseCollection
     */
    public function merge($arIDList = []): BaseCollection
    {
        $this->arIDList = array_merge($this->arIDList, $arIDList);

        return $this->returnThis();
    }

    /**
     * @return BaseCollection
     */
    public function unique(): BaseCollection
    {
        $this->arIDList = array_unique($this->arIDList);

        return $this->returnThis();
    }

    /**
     * @param array $arIDList
     *
     * @return BaseCollection
     */
    public function exclude($arIDList = []): BaseCollection
    {
        foreach ($arIDList as $iID) {
            if (($bKey = array_search($iID, $this->arIDList)) !== false) {
                unset($this->arIDList[$bKey]);
            }
        }

        return $this->returnThis();
    }

    /**
     * @param $func
     *
     * @return array
     */
    public function each($func): array
    {
        $arResult = [];
        foreach ($this->arIDList as $iItemID) {
            $obItem = $this->makeItem($iItemID);
            $arResult[] = $func($obItem);
        }

        return $arResult;
    }

    /**
     * @return BaseItem[]
     */
    public function all()
    {
        if ($this->isClear()) {
            return [];
        }

        /** @var []BaseItem $arResult */
        $arResult = [];
        foreach ($this->arIDList as $iElementID) {
            $arResult[$iElementID] = $this->makeItem($iElementID);
        }

        return $arResult;
    }

    public function first()
    {
        if ($this->isClear()) {
            return null;
        }

        return $obItem = $this->makeItem($this->arIDList[0]);
    }

    public function forResponse(): array
    {
        $arResult = [];

        foreach ($this->arIDList as $iElementID) {
            $obElement = $this->makeItem($iElementID);
            $arResult[] = $obElement->toArray();
        }

        return $arResult;
    }

    public function last()
    {
        $iTotalLength = count($this->arIDList);

        return $this->makeItem($this->arIDList[$iTotalLength - 1]);
    }

    /**
     * @return bool
     */
    public function isClear() : bool
    {
        return count($this->arIDList) <= 0;
    }

    /**
     * @return bool
     */
    public function isEmpty() : bool
    {
        return empty($this->arIDList);
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @return int
     */
    public function count() : int
    {
        return count($this->arIDList);
    }

    /**
     * @param int $iLimit
     * @param int $iPosition
     *
     * @return BaseItem[]
     */
    public function limit($iLimit, $iPosition = 0)
    {
        if (empty($iLimit) || $iLimit <= 0) {
            return [];
        }

        $arSliceIDList = array_slice($this->arIDList, $iPosition, $iLimit);
        if (empty($arSliceIDList)) {
            return [];
        }

        $arResult = [];
        foreach ($arSliceIDList as $iID) {
            $arResult[$iID] = $this->makeItem($iID);
        }

        return $arResult;
    }

    /**
     * @param string $sParam
     * @param $aValue
     *
     * @return $this
     */
    public function where($sParam, $aValue) : self
    {
        if (empty($sParam) || empty($aValue) || empty($this->arIDList)) {
            return $this->returnThis();
        }

        $arResult = [];

        foreach ($this->arIDList as $iID) {
            $obItem = $this->makeItem($iID);
            if (empty($obItem)) {
                continue;
            }

            if (empty($obItem->getAttribute($sParam))) {
                continue;
            }

            $arResult[] = $iID;
        }

        $this->intersect($arResult);
        return $this->returnThis();
    }

    /**
     * @return $this
     */
    public function returnThis(): BaseCollection
    {
        return $this;
    }

    /**
     * @param array $arElementIDList
     *
     * @return $this
     */
    public static function make($arElementIDList = [])
    {
        /** @var BaseCollection $obCollection */
        $obCollection = app()->make(static::class);

        if (!empty($arElementIDList) && is_array($arElementIDList)) {
            $obCollection->arIDList = $arElementIDList;
        }

            return $obCollection->returnThis();
    }

    /**
     * @param $iElementID
     *
     * @return BaseItem
     */
    protected function makeItem($iElementID)
    {
        /** @var BaseItem $sItemClass */
        $sItemClass = $this->getItemClass();

        return $sItemClass::make($iElementID);
    }

    abstract protected static function getItemClass() : string;

    public function current()
    {
        return $this->makeItem($this->arIDList[$this->iPosition]);
    }

    public function valid()
    {
        return isset($this->arIDList[$this->iPosition]);
    }

    public function rewind()
    {
        $this->iPosition = 0;
    }

    public function next()
    {
        ++$this->iPosition;
    }

    public function key()
    {
        return $this->iPosition;
    }
}