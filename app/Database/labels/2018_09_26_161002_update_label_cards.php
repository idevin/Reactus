<?php

use App\Models\NeoCard;
use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Migrations\Migration;

class UpdateLabelCards extends Migration {

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

                if($card->name == "") {
                    if (!$card->no_parent) {
                        $card->no_parent = true;
                    }
                    if (!$card->hidden) {
                        $card->hidden = true;
                    }

                } else {
                    if (!$card->no_parent) {
                        $card->no_parent = false;
                    }
                    if (!$card->hidden) {
                        $card->hidden = false;
                    }
                }

                $card->save();
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
