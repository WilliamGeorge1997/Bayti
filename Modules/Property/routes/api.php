<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Property\App\Http\Controllers\Api\PropertyController;
use Modules\Property\App\Http\Controllers\Api\PropertyAdminController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/
Route::group(['prefix' => 'admin'], function () {
    Route::apiResource('properties', PropertyAdminController::class)->only(['index']);
    Route::post('properties/{property}/toggle-activate', [PropertyAdminController::class, 'toggleActivate']);
});

Route::apiResource('properties', PropertyController::class)->except(['update', 'delete']);
Route::post('properties/{property}/toggle-available', [PropertyController::class, 'toggleAvailable']);
