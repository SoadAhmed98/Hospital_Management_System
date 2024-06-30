<?php

namespace App\Repositories\Interfaces;

use App\Models\Appointment;

interface AppointmentAPIRepositoryInterface
{
    public function create(array $data): Appointment;
}
