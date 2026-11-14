<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\ShiftTemplateController;
use Illuminate\Support\Facades\Route;

Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/shift-templates', [ShiftTemplateController::class, 'index']);

Route::get('/schedules/{schedule}', [ScheduleController::class, 'show']);
Route::post('/schedules/{schedule}/save', [ScheduleController::class, 'save']);
Route::post('/schedules/{schedule}/publish', [ScheduleController::class, 'publish']);

Route::get('/schedules/{schedule}/shifts', [ShiftController::class, 'index']);
Route::post('/schedules/{schedule}/shifts', [ShiftController::class, 'store']);
Route::post('/schedules/{schedule}/shifts/bulk', [ShiftController::class, 'bulkAssign']);
Route::post('/schedules/{schedule}/shifts/move', [ShiftController::class, 'move']);

Route::put('/shifts/{shift}', [ShiftController::class, 'update']);
Route::delete('/shifts/{shift}', [ShiftController::class, 'destroy']);