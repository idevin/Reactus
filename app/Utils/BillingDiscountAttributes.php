<?php

namespace App\Utils;


trait BillingDiscountAttributes
{

    public function getDiscountPriceAttribute()
    {
        if ($this->amount == 0 || ($this->amount >= $this->price)) {
            return 0;
        }

        return round($this->price - $this->amount, 2);
    }

    protected function getPriceInterestAttribute()
    {
        if ($this->amount == 0 || $this->price == 0) {
            return 0;
        }

        return ($this->amount / $this->price) * 100;
    }

    protected function getDiscountBallAttribute()
    {
        if ($this->ball_discount == 0 || ($this->ball_discount >= $this->ball)) {
            return 0;
        }

        return round($this->ball - $this->ball_discount, 2);
    }

    protected function getBallInterestAttribute()
    {
        if ($this->ball_discount== 0 || $this->ball== 0) {
            return 0;
        }

        return ($this->ball_discount / $this->ball) * 100;
    }

}