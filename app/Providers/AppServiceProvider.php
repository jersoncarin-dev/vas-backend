<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Pusher\PushNotifications\PushNotifications;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PushNotifications::class, function () {
            $config = config('services.pusher');
            
            return new PushNotifications([
                'instanceId' => $config['beams_instance_id'],
                'secretKey' => $config['beams_secret_key'],
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceScheme('https');
        Paginator::useBootstrap();
    }
}
