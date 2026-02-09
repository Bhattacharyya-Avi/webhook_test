<?php

namespace App\Http\Controllers;
/**
 * this controller is for child project . this required a route and token in the .env file to update data
 * route Route::post('webhook/update-config', [WebhookController::class, 'updateConfig']);
 * .env variable WEBHOOK_TOKEN=IP9zt5gbUu3sbRjc51YobOTjhBcHgvkaGvFGKDQop5rccwtpwkaAiz3IzAYaW8CV 
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function updateConfig(Request $request) {
        // dd($request->all());
        // Validate token (assuming Bearer token matches what's stored in parent)
        if ($request->bearerToken() !== env('WEBHOOK_TOKEN')) {  // Set in .env of child
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $company = DB::table('gnr_company')->where('status',1)
        ->update([
            'package_config' =>json_encode($request->all())
        ]);
        // Log::info(json_encode($request->all()));
        return response()->json(['status'=>true,'message' => 'Config updated successfully.']);
    }
}
