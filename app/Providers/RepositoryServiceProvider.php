<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Departments\DepartmentRepositoryInterface;
use App\Repository\Departments\DepartmentRepository;
use App\Interfaces\Departments\DepartmentAPIRepositoryInterface;
use App\Repository\Departments\DepartmentAPIRepository;



class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(DepartmentAPIRepositoryInterface::class, DepartmentAPIRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
