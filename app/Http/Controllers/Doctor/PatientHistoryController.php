<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use App\Interfaces\doctor_dashboard\PatientHistoryRepositoryInterface;
use Illuminate\Http\Request;

class PatientHistoryController extends Controller
{

    private $PatientHistory;

    public function __construct(PatientHistoryRepositoryInterface $PatientHistory)
    {
        $this->PatientHistory = $PatientHistory;
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        return $this->PatientHistory->store($request);
    }

    public function addReview (Request $request)
    {
        return $this->PatientHistory->addReview($request);
    }


    public function show($id)
    {
        return $this->PatientHistory->show($id);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}