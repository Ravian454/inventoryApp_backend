<?php

// use App\Http\Controllers\UserController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('api')->group(function () {
    Route::post('/insertData', [UserController::class, 'insertData']);
});

Route::middleware('api')->group(function () {
    Route::get('/getData', [UserController::class, 'getData']);
});

Route::middleware('api')->group(function () {
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/deleteImage/{imageName}', [UserController::class, 'deleteImage']);
});


