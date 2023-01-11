<?php namespace App\Listeners;


use App\Events\OrderEvent;
use App\Jobs\ProcessOrder;

class OrderListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderEvent  $obEvent
     * @return void
     */
    public function handle(OrderEvent $obEvent)
    {
        if (!$this->validate($obEvent)) {
            return;
        }

        ProcessOrder::dispatch($obEvent->serializeItems())->delay(null);
    }

    protected function validate(OrderEvent $obEvent) : bool
    {
        return $obEvent->valid();
    }
}