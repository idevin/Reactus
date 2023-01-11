<?php namespace App\Models;

/**
 * Class OrderItem
 * @package App\Models
 *
 * @property string $name
 * @property string $comment
 * @property string $count
 * @property float $price
 * @property float $discount
 */
class OrderItem
{
    protected $arFields = [
        'name' => '',
        'count' => '',
        'comment' => '',
        'price' => 0.0,
        'discount' => 0.0,
    ];

    /**
     * @param array $arAttributes
     * @return OrderItem
     */
    public static function fromCompleteArray($arAttributes = []): OrderItem
    {
        $new = new self();
        foreach ($arAttributes as $sAttrKey => $uAttrValue) {
            $new->{$sAttrKey} = $uAttrValue;
        }

        return $new;
    }

    /**
     * @param $sStringItem
     * @return OrderItem
     */
    public static function decodeFromString($sStringItem): OrderItem
    {
        if (empty($sStringItem) || !is_string($sStringItem)) {
            return new OrderItem();
        }

        $item = new self();
        $arAttributes = json_decode($sStringItem, true);
        foreach ($arAttributes as $sAttrKey => $uAttrValue) {
            $item->$sAttrKey = $uAttrValue;
        }

        return $item;
    }

    public function __toString()
    {
        return json_encode($this->arFields);
    }

    public function toString()
    {
        return json_encode($this->arFields);
    }

    public function __get($name)
    {
        if (!in_array($name, array_keys($this->arFields))) {
            return null;
        }

        return $this->arFields[$name];
    }

    public function __set($name, $value)
    {
        if (!in_array($name, array_keys($this->arFields))) {
            return;
        }

        $this->arFields[$name] = $value;
    }
}