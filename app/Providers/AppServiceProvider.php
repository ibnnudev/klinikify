<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(\App\Interfaces\DoctorCategoryInterface::class, \App\Repositories\DoctorCategoryRepository::class);
        $this->app->bind(\App\Interfaces\DoctorInterface::class, \App\Repositories\DoctorRepository::class);
        $this->app->bind(\App\Interfaces\PatientInterface::class, \App\Repositories\PatientRepository::class);
        $this->app->bind(\App\Interfaces\MedicineInterface::class, \App\Repositories\MedicineRepository::class);
        $this->app->bind(\App\Interfaces\ReservationInterface::class, \App\Repositories\ReservationRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
