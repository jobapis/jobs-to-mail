<?php

namespace JobApis\JobsToMail\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        $this->app->bind(
            \JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface::class,
            \JobApis\JobsToMail\Repositories\UserRepository::class
        );
    }
}
