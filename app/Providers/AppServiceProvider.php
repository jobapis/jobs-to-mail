<?php namespace JobApis\JobsToMail\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use JobApis\Jobs\Client\JobsMulti;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Only premium users can set this value to true
        Validator::extend('premium', function($attribute, $value, $parameters, $validator) {
            if ($value == 1) {
                return config('app.user_tiers.premium') === session()->get('user.tier');
            }
            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Search Repository
        $this->app->bind(
            \JobApis\JobsToMail\Repositories\Contracts\SearchRepositoryInterface::class,
            \JobApis\JobsToMail\Repositories\SearchRepository::class
        );
        // User Repository
        $this->app->bind(
            \JobApis\JobsToMail\Repositories\Contracts\UserRepositoryInterface::class,
            \JobApis\JobsToMail\Repositories\UserRepository::class
        );
        // Job board API client
        $this->app->bind(JobsMulti::class, function () {
            return new JobsMulti(config('jobboards'));
        });
    }
}
