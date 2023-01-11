<?php

namespace App\Jobs;

use App\Events\OrderEvent;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $obEvent = null;

    /**
     * ProcessOrder constructor.
     * @param OrderEvent $obEvent
     */
    public function __construct(OrderEvent $obEvent)
    {
        $this->obEvent = $obEvent;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->obEvent)) {
            return;
        }

        $this->obEvent->unserializeItems();

        /** @var Order $obOrder */
        $obOrder = Order::create([
            'name' => $this->obEvent->obUser->first_name,
            'email' => $this->obEvent->obUser->email,
            'phone' => $this->obEvent->obUser->phone,
            'delivery_address' => $this->obEvent->sDeliveryAddress,
            'delivery_time' => $this->obEvent->obDeliveryTime,
            'site_id' => $this->obEvent->iSiteID,
            'user_id' => $this->obEvent->obUser->id,
        ]);

        $obOrder->addItem($this->obEvent->arOrderList);
        $obOrder->save();
    }
}
