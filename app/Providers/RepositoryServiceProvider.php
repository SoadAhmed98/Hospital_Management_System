<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Doctors\DoctorRepository;
use App\Repository\Finance\PaymentRepository;

use App\Repository\Finance\ReceiptRepository;
use App\Repository\Patients\PatientRepository;


use App\Repository\Doctors\DoctorAPIRepository;
use App\Repository\Finance\PaymentAPIRepository;

use App\Repository\Finance\ReceiptAPIRepository;
use App\Repository\Patients\PatientAPIRepository;

use App\Repository\Departments\DepartmentRepository;
use App\Repository\Services\SingleServiceRepository;

use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Interfaces\Finance\PaymentRepositoryInterface;

use App\Interfaces\Finance\ReceiptRepositoryInterface;
use App\Interfaces\Patients\PatientRepositoryInterface;

use App\Repository\Appointmentes\AppointmentRepository;
use App\Repository\Departments\DepartmentAPIRepository;

use App\Repository\doctor_dashboard\InvoicesRepository;
use App\Repository\Services\SingleServiceAPIRepository;
use App\Interfaces\Doctors\DoctorAPIRepositoryInterface;
use App\Interfaces\Finance\PaymentAPIRepositoryInterface;
use App\Interfaces\Finance\ReceiptAPIRepositoryInterface;
use App\Interfaces\Patients\PatientAPIRepositoryInterface;
use App\Repository\Appointmentes\AppointmentAPIRepository;
use App\Repository\doctor_dashboard\LaboratoriesRepository;
use App\Interfaces\Departments\DepartmentRepositoryInterface;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use App\Repository\doctor_dashboard\PatientHistoryRepository;
use App\Interfaces\Appointmentes\AppointmentRepositoryInterface;
use App\Interfaces\Departments\DepartmentAPIRepositoryInterface;
use App\Interfaces\doctor_dashboard\InvoicesRepositoryInterface;

use App\Interfaces\Services\SingleServiceAPIRepositoryInterface;
use App\Interfaces\Appointmentes\AppointmentAPIRepositoryInterface;

use App\Interfaces\doctor_dashboard\LaboratoriesRepositoryInterface;
use App\Repository\LaboratorieEmployee\LaboratorieEmployeeRepository;

use App\Interfaces\doctor_dashboard\PatientHistoryRepositoryInterface;
use App\Interfaces\LaboratorieEmployee\LaboratorieEmployeeRepositoryInterface;



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
        $this->app->bind(ReceiptRepositoryInterface::class, ReceiptRepository::class);
        $this->app->bind(ReceiptAPIRepositoryInterface::class, ReceiptAPIRepository::class);

        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(AppointmentAPIRepositoryInterface::class, AppointmentAPIRepository::class);

        $this->app->bind(SingleServiceAPIRepositoryInterface::class, SingleServiceAPIRepository::class);


        $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
        $this->app->bind(DoctorAPIRepositoryInterface::class, DoctorAPIRepository::class);
        $this->app->bind(SingleServiceRepositoryInterface::class, SingleServiceRepository::class);


        // doctor
        $this->app->bind(InvoicesRepositoryInterface::class, InvoicesRepository::class);

        $this->app->bind(PatientHistoryRepositoryInterface::class, PatientHistoryRepository::class);

        $this->app->bind(LaboratoriesRepositoryInterface::class, LaboratoriesRepository::class);

        $this->app->bind(LaboratorieEmployeeRepositoryInterface::class, LaboratorieEmployeeRepository::class);

        //Dashboard_Laboratorie_Employee
        $this->app->bind('App\Interfaces\Dashboard_Laboratorie_Employee\InvoicesRepositoryInterface',
            'App\Repository\Dashboard_Laboratorie_Employee\InvoicesRepository');


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
