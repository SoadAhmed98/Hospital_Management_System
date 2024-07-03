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

use App\Repository\Finance\ReceiptRepository;
use App\Interfaces\Finance\ReceiptRepositoryInterface;

use App\Repository\Finance\ReceiptAPIRepository;
use App\Interfaces\Finance\ReceiptAPIRepositoryInterface;

use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Repository\Doctors\DoctorRepository;
use App\Interfaces\Doctors\DoctorAPIRepositoryInterface;
use App\Repository\Doctors\DoctorAPIRepository;
use App\Interfaces\Services\SingleServiceRepositoryInterface;
use App\Repository\Services\SingleServiceRepository;
use App\Interfaces\Services\SingleServiceAPIRepositoryInterface;
use App\Repository\Services\SingleServiceAPIRepository;
use App\Interfaces\Appointmentes\AppointmentRepositoryInterface;
use App\Repository\Appointmentes\AppointmentRepository;
use App\Interfaces\Appointmentes\AppointmentAPIRepositoryInterface;
use App\Repository\Appointmentes\AppointmentAPIRepository;
use App\Interfaces\doctor_dashboard\InvoicesRepositoryInterface;
use App\Repository\doctor_dashboard\InvoicesRepository;

use App\Interfaces\doctor_dashboard\PatientHistoryRepositoryInterface;
use App\Repository\doctor_dashboard\PatientHistoryRepository;

use App\Interfaces\doctor_dashboard\LaboratoriesRepositoryInterface;
use App\Repository\doctor_dashboard\LaboratoriesRepository;

use App\Interfaces\LaboratorieEmployee\LaboratorieEmployeeRepositoryInterface;
use App\Repository\LaboratorieEmployee\LaboratorieEmployeeRepository;



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


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
