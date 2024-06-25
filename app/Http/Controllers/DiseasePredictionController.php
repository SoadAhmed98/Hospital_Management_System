<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiseasePredictionController extends Controller
{
    public function predict(Request $request)
    {
        $response = Http::post('http://127.0.0.1:5000/predict', [
            'symptoms' => $request->symptoms,
        ]);

        return response()->json($response->json());
    }
}
