<?php

use App\Http\Controllers\Api\ApiLoginController;
use App\Http\Controllers\Api\ApiStudentController;
use App\Http\Controllers\Api\ApiTeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('test', [StudentApiController::class, 'test']);

Route::post('login', [ApiLoginController::class, 'login']);
Route::post('register', [ApiLoginController::class, 'register']);

Route::apiResource('student', ApiStudentController::class);
Route::apiResource('teacher', ApiTeacherController::class);

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('student-profile', [ApiLoginController::class, 'studentProfile']);
});


