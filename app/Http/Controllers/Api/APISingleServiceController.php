<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\SingleServiceAPIRepositoryInterface;
use Illuminate\Http\Request;

class APISingleServiceController extends Controller
{
    private $services;

    public function __construct(SingleServiceAPIRepositoryInterface $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        return response()->json($this->services->index());
    }

    public function show($id)
    {
        return response()->json($this->services->show($id));
    }

    

}
