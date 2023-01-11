<?php

use App\Models\NeoCard;
use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Migrations\Migration;

class AddSeoSlugToCards extends Migration
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
                $card->update(['seo_slug' => slugify($card->name)]);
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
