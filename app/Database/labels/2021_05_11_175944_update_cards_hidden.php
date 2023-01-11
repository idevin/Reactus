<?php

use App\Models\NeoCard;
use Vinelab\NeoEloquent\Migrations\Migration;

class UpdateCardsHidden extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $cards = NeoCard::all();
        if (count($cards) > 0) {
            foreach ($cards as $card) {
                    $card->update(['hidden' => 0]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
