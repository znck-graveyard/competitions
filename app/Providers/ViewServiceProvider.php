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