<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\App\Interfaces\DoctorCategoryInterface::class, \App\Repositories\DoctorCategoryRepository::class);
        $this->app->bind(\App\Interfaces\DoctorInterface::class, \App\Repositories\DoctorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
