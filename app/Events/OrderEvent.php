<?php namespace App\Events;

use App\Models\OrderItem;
use App\Models\Site;
use App\Models\User;
use Carbon\Carbon;

/**
 * Class OrderEvent
 * @package App\Events
 * @author ilya beltyukov, 968597@gmail.com
 */
class OrderEvent extends Event
{
    const DEFAULT_DELIVERY_ADDRESS = 'Самовывоз';

    public $obUser = null;

    public $iSiteID = null;

    /** @var OrderItem[] $arOrderList */
    public $arOrderList = [];

    /** @var \Illuminate\Support\Carbon $obCreatedAt */
    public $obCreatedAt = null;

    /** @var string $sDeliveryAddress */
    public $sDeliveryAddress = self::DEFAULT_DELIVERY_ADDRESS;

    /** @var Carbon $obDeliveryTime */
    public $obDeliveryTime = null;

    protected $bValid = true;

    /**
     * OrderEvent constructor.
     * @param OrderItem[] $arOrderList
     * @param User $obUser
     * @param Site $obSite
     * @param array $arDelivery
     */
    public function __construct($arOrderList,User $obUser,Site $obSite, $arDelivery = [])
    {
        if (!empty($obUser)) {
            $this->bValid = true;
        }

        $this->obCreatedAt = now();
        $this->obUser = $obUser;
        $this->arOrderList = $arOrderList;

        if (isset($arDelivery['address']) && !empty($arDelivery['address'])) {
            $this->sDeliveryAddress = $arDelivery['address'];
        }

        if (isset($arDelivery['time']) && !empty($arDelivery['time'])) {
            $this->obDeliveryTime = $arDelivery['time'];
        }

        $this->iSiteID = $obSite->id;
    }

    public function valid() : bool
    {
        return $this->bValid;
    }

    public function serializeItems()
    {
        $arTemp = [];
        foreach ($this->arOrderList as $obItem) {
            if (!$obItem instanceof OrderItem) {
                continue;
            }
            $arTemp[] = $obItem->toString();
        }
        $this->arOrderList = $arTemp;
        return $this;
    }

    public function unserializeItems()
    {
        $arTemp = [];
        foreach ($this->arOrderList as $obItem) {
            if (!is_string($obItem)) {
                continue;
            }

            $arTemp[] = OrderItem::decodeFromString($obItem);
        }
        $this->arOrderList = $arTemp;
        return $this;
    }

    /**
     * @param OrderItem[] $arOrderList
     * @param User $obUser
     * @param Site $obSite
     * @param array $arDelivery
     */
    public static function make($arOrderList, User $obUser, Site $obSite, $arDelivery = [])
    {
        event(new self($arOrderList, $obUser, $obSite, $arDelivery));
    }
}