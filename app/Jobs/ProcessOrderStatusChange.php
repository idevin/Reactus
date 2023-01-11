<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessOrderStatusChange implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Order $obOrder */
    protected $obOrder = null;
    protected $sStatusAction = '';
    protected $bSet = false;

    protected $bFail = false;

    /**
     * ProcessOrderStatusChange constructor.
     * @param array $arParams
     */
    public function __construct($arParams)
    {
        if (!isset($arParams['action']) || empty($arParams['action'])) {
            $this->bFail = true;
            return;
        }

        $this->sStatusAction = $arParams['action'];

        if (!isset($arParams['order']) || empty($arParams['order'])) {
            $this->bFail = true;
            return;
        }

        $this->obOrder = $arParams['order'];

        if (isset($arParams['set'])) {
            $this->bSet = $arParams['set'];
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->bFail) {
            return;
        }

        switch ($this->sStatusAction) {
            case OrderStatus::STATUS_PROCESSED :
                $this->processActionProcessed();
                break;
            case OrderStatus::STATUS_SHIPPED :
                $this->processActionShipped();
                break;
        }
    }

    private function processActionProcessed()
    {
        var_dump('Processed action');
    }

    private function processActionShipped()
    {
        var_dump('Shipped action');
    }
}
