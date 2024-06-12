<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Departments\DepartmentRepositoryInterface;
use App\Repository\Departments\DepartmentRepository;
use App\Interfaces\Departments\DepartmentAPIRepositoryInterface;
use App\Repository\Departments\DepartmentAPIRepository;

use App\Interfaces\Patients\PatientRepositoryInterface;
use App\Repository\Patients\PatientRepository;
use App\Interfaces\Patients\PatientAPIRepositoryInterface;
use App\Repository\Patients\PatientAPIRepository;



class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(DepartmentAPIRepositoryInterface::class, DepartmentAPIRepository::class);
        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
        $this->app->bind(PatientAPIRepositoryInterface::class, PatientAPIRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
