<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProgrammesController;
use App\Http\Controllers\ActivePrograms;

Route::post('/admins/register', [AdminController::class, 'registerAdmin']);
Route::post('/admins/login', [AdminController::class, 'loginAdmin']);

Route::get('/admins', [AdminController::class, 'index'])->middleware('auth');
Route::post('/admins/update', [AdminController::class, 'update'])->middleware('auth');
Route::get('/admins/{id}', [AdminController::class, 'show'])->middleware('auth');
Route::delete('/admins/{id}/delete', [AdminController::class, 'destroy'])->middleware('auth');

Route::post('/programmes/store', [ProgrammesController::class, 'store'])->middleware('auth');
Route::get('/programmes',[ProgrammesController::class, 'index'])->middleware('auth');
Route::get('/programmes/{id}',[ProgrammesController::class, 'show'])->middleware('auth');
Route::delete('/programmes/{id}/delete',[ProgrammesController::class, 'destroy'])->middleware('auth');

Route::get('/activeprogrammes/index/{cnp}', [ActivePrograms::class, 'index']);
Route::post('/activeprogrammes/{id}', [ActivePrograms::class, 'store']);
Route::delete('/activeprogrammes/{id}/{cnp}', [ActivePrograms::class, 'destroy']);

// Route::post('/programmes/store',[ProgrammesController::class, 'store']);
