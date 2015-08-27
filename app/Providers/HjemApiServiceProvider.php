<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class HjemApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('HjemClient', function ($app) {
            $client = new Client([
                'base_uri' => env('HJEM_API_BASE_URL') . '/v1/',
                'timeout'  => 10.0,
                'exceptions' => FALSE
            ]);

            return $client;
        });
    }
}
