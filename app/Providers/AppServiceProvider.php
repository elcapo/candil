<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\Person;
use App\Observers\ActivistObserver;
use App\Observers\GroupObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Person::observe(ActivistObserver::class);
        Group::observe(GroupObserver::class);
    }
}
