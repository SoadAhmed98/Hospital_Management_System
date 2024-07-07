<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientHistory;
use App\Models\Laboratorie;
use Illuminate\Http\Request;

class APIPatientDetailsController extends Controller
{
    public function index($id)
    {
        // Fetch patient records
        $patient_records = PatientHistory::where('patient_id', $id)->get();

        // Fetch laboratory records and their associated images
        $patient_Laboratories = Laboratorie::with('images')->where('patient_id', $id)->get();

        // Prepare the response data
        $response = [
            'patient_records' => $patient_records,
            'patient_laboratories' => $patient_Laboratories->map(function ($laboratorie) {
                return [
                    'id' => $laboratorie->id,
                    'description_employee' => $laboratorie->description_employee,
                    'images' => $laboratorie->images->map(function ($image) {
                        return [
                            'filename' => $image->filename,
                            'url' => asset('Dashboard/img/laboratories/' . $image->filename),
                        ];
                    }),
                ];
            }),
        ];

        // Return the response as JSON
        return response()->json($response);
    }

}