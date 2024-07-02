<?php
// app/Repositories/AppointmentRepository.php

namespace App\Repository\Appointmentes;

use App\Models\Appointment;
use App\Interfaces\Appointmentes\AppointmentRepositoryInterface;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }
}

