<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data = null) {
            return Response::json([
              'errors'  => false,
              'data' => $data,
            ]);
        });

        Response::macro('fail', function ($errors, $status = 400) {
            return Response::json(['errors'  => $errors], $status);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
