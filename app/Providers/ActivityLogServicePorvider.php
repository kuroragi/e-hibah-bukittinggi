<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ActivityLogService;

class ActivityLogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('activitylog', function ($app) {
            return new ActivityLogService();
        });

        // juga: alias app('activitylog') => ActivityLogService class ketika di type-hint
        $this->app->alias('activitylog', ActivityLogService::class);
    }

    public function boot()
    {
        //
    }
}
