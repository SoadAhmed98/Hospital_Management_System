<?php

namespace App\Repository;

use App\Models\Appointment;
use App\Repositories\Interfaces\AppointmentAPIRepositoryInterface;

class AppointmentAPIRepository implements AppointmentAPIRepositoryInterface
{
    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }
}
