<?php

namespace App\Repository;

use App\Models\Appointment;
use App\Interfaces\Appointmentes\AppointmentAPIRepositoryInterface;

class AppointmentAPIRepository implements AppointmentAPIRepositoryInterface
{
    public function store($request)
    {
        return Appointment::create($request);
    }

}
