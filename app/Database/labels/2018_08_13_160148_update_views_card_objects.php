<?php

use App\Models\NeoCard;
use Vinelab\NeoEloquent\Migrations\Migration;

class UpdateViewsCardObjects extends Migration
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
                $card->update(['views' => 0]);
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
