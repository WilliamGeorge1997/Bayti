<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/testnotif', function () { {
        $token = "ExponentPushToken[S5kY1OMdabMaVKRo42_HUW]"; // Your real token

        $payload = [
            'to' => $token,
            'sound' => 'default',
            'title' => 'Raw Test',
            'body' => 'Direct API test',
        ];

        $ch = curl_init('https://exp.host/--/api/v2/push/send');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $result = curl_exec($ch);
        curl_close($ch);

        return response()->json(['result' => json_decode($result, true)]);
    }
});
