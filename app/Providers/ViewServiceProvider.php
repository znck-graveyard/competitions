<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * This file belongs to competitions.
 *
 * Author: Rahul Kadyan, <hi@znck.me>
 * Find license in root directory of this project.
 */
class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('trending.contests', \App\View\Composer\TrendingContest::class);
        view()->composer('trending.categories', \App\View\Composer\ContestInCategory::class);
        view()->composer('stats.counter', \App\View\Composer\StatsComposer::class);
        view()->composer('pills', \App\View\Composer\PillComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}