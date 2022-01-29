<?php

namespace App\Providers;

use Godruoyi\Snowflake\Snowflake;
use Illuminate\Support\ServiceProvider;
use Godruoyi\Snowflake\RandomSequenceResolver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('snowflake', function() {
            return (new Snowflake(
                config('snowflake.data_center'),
                config('snowflake.worker_node'))
            )
                ->setStartTimeStamp(strtotime('2022-01-27') * 1000)
                ->setSequenceResolver(new RandomSequenceResolver());
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('global', function (Request $request) {
            return Limit::perMinute(1000);
        });

        RateLimiter::for('create', function (Request $request) {
            return Limit::perMinute(5);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
