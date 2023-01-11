<?php

namespace App\Database\DefaultSeeds;

use App\Models\User;
use App\Traits\Utils;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class Users extends Seeder
{
    use Utils;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        Model::unguard();

        $root = 'root';
        $password = 'ifiksxjr111';

        $user = User::query()->whereUsername($root)->first();

        $data = [
            'username' => $root,
            'password' => bcrypt($password),
            'email' => env('MAIL_NOREPLY'),
            'auth_token' => User::authToken(),
            'domain' => $root . '.' . env('DEFAULT_PERSONAL_DOMAIN'),
            'superadmin' => 1,
            'active' => 1,
            'rating' => 0,
            'locked' => 0,
            'balance' => 0,
            'autorenew' => 0
        ];

        if ($user) {
            $user->update($data);
        } else {
            User::firstOrCreate($data);
        }
    }
}
