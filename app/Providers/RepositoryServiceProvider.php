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

use App\Repository\Finance\PaymentRepository;
use App\Interfaces\Finance\PaymentRepositoryInterface;

use App\Repository\Finance\PaymentAPIRepository;
use App\Interfaces\Finance\PaymentAPIRepositoryInterface;

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
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(PaymentAPIRepositoryInterface::class, PaymentAPIRepository::class);


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
