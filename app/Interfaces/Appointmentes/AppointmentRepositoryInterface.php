<?php

namespace App\Interfaces\Appointmentes;

use App\Models\Appointment;

interface AppointmentRepositoryInterface
{
    public function create(array $data): Appointment;
}
