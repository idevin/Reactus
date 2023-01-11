<?php

use App\Models\NeoCard;
use Vinelab\NeoEloquent\Migrations\Migration;

class UpdateSeoCards extends Migration
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
                if (!$card->seo_title) {
                    $card->seo_title = '';
                }
                if (!$card->seo_description) {
                    $card->seo_description = '';
                }
                if (!$card->seo_h1) {
                    $card->seo_h1 = '';
                }
                if (!$card->views) {
                    $card->views = 0;
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
