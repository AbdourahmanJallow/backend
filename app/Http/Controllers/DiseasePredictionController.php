<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

use function Laravel\Prompts\error;

class DiseasePredictionController extends Controller
{
    public function predictDisease(Request $request)
    {
        info("Sending request to Flask API with symptoms: " . $request->symptoms);

        // Call the Python API
        try {
            $response = Http::timeout(10)->post('http://localhost:5318/predict', [
                'symptoms' => $request->symptoms
            ]);

            info("Received response: " . json_encode($response->json()));

            return response()->json(["predicted_disease" => $response->json()['predicted_disease']]);
            // return back()->with(
            //     'predicted_disease',
            //     $response->json()['predicted_disease']
            // );
        } catch (\Exception $e) {
            error("Error calling Flask API: " . $e->getMessage());
            return redirect()->back()->withErrors("Failed to connect to prediction service.");
        }
    }

    public function diseasePredictor()
    {
        return Inertia::render('DiseasePredictor');
    }
}
