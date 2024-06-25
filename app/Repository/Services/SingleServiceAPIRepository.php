<?php

namespace App\Repository\Services;

use App\Interfaces\Services\SingleServiceAPIRepositoryInterface;
use App\Models\Service;

class SingleServiceAPIRepository implements SingleServiceAPIRepositoryInterface
{
    public function index()
    {
        return Service::all();
    }

    public function show($id)
    {
        return Service::findOrFail($id);
    }

   
}
