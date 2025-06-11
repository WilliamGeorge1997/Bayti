<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Property\App\Http\Controllers\Api\PropertyController;

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

Route::apiResource('properties', PropertyController::class)->except(['update','delete']);