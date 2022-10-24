<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use App\Observers\UserObserver;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Observers\RoleObserver;
use App\Models\Gender;
use App\Observers\GenderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS'))
        {
            $url->formatScheme('https://');
        }

        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        Gender::observe(GenderObserver::class);
    }
}
