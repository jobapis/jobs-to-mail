<?php namespace JobApis\JobsToMail\Providers;

use Illuminate\Support\ServiceProvider;
use JobApis\Jobs\Client\JobsMulti;
use League\Csv\Writer;

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
        $this->app->bind(JobsMulti::class, function() {
            return new JobsMulti(config('jobboards'));
        });
        // CSV Writer
        $this->app->bind('League\Csv\Writer', function() {
            return Writer::createFromString('');
        });
    }
}
