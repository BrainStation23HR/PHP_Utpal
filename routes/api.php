<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceDataController;
use App\Http\Controllers\DeviceStatusController;
use App\Http\Controllers\UpdateDeviceDataController;
use App\Http\Controllers\DeviceStatusHistoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/device-data', DeviceDataController::class);
Route::get('/devices/{device_id}/status', DeviceStatusController::class);
Route::get('/device/{device_id}/history', DeviceStatusHistoryController::class);
Route::patch('/device/{id}', UpdateDeviceDataController::class);