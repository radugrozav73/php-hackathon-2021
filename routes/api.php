<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Register;

Route::post('/register', [Register::class, 'store']);
Route::post('/login', [Register::class, 'store']);
