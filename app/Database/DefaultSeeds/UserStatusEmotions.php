<?php

namespace App\Database\DefaultSeeds;

use App\Models\UserStatusEmotion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserStatusEmotions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = ['happy', 'pessimistic', 'angry'];

        foreach ($data as $name) {

            $e = UserStatusEmotion::whereName($name)->first();
            if (!$e) {
                UserStatusEmotion::firstOrCreate(['name' => $name]);
            }
        }
    }
}
