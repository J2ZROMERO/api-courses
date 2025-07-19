<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Support\Facades\Route;

Route::Post('/login', [AuthController::class, 'login']);
Route::Post('/register', [RegisterController::class, 'register']);
