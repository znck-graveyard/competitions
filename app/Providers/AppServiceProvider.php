<?php namespace App\Providers;

use App\Contest;
use App\Entry;
use App\Judge;
use App\PublishedScope;
use Illuminate\Support\ServiceProvider;
use Rhumsaa\Uuid\Uuid;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Judge::creating(function (Judge $judge) {
            $judge->token = Uuid::uuid4()->toString();
        });

        Entry::creating(function (Entry $entry) {
            $entry->uuid = Uuid::uuid4()->toString();
        });
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Illuminate\Contracts\Auth\Registrar',
            'App\Services\Registrar'
        );
    }

}
