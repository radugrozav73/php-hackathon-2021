<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProgrammesController;
use App\Http\Controllers\ActivePrograms;

Route::post('/admins/register', [AdminController::class, 'registerAdmin']);
Route::post('/admins/login', [AdminController::class, 'loginAdmin']);

Route::group(['middleware' => 'auth'], function(){

    Route::get('/admins', [AdminController::class, 'index']);
    Route::post('/admins/update', [AdminController::class, 'update']);
    Route::get('/admins/{id}', [AdminController::class, 'show']);
    Route::delete('/admins/{id}/delete', [AdminController::class, 'destroy']);

    Route::post('/programmes/store', [ProgrammesController::class, 'store']);
    Route::get('/programmes',[ProgrammesController::class, 'index']);
    Route::get('/programmes/{id}',[ProgrammesController::class, 'show']);
    Route::post('/programmes/update/{id}', [ProgrammesController::class, 'update']);
    Route::delete('/programmes/{id}/delete',[ProgrammesController::class, 'destroy']);

    Route::get('/activeprogrammes/index/{cnp}', [ActivePrograms::class, 'index'])->middleware('throttle:60,60');
});

Route::post('/activeprogrammes/{id}', [ActivePrograms::class, 'store']);
Route::delete('/activeprogrammes/{id}/{cnp}', [ActivePrograms::class, 'destroy']);