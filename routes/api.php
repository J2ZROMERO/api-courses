<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ElementController;
use App\Http\Controllers\Api\SectionController;
use Illuminate\Support\Facades\Route;

Route::Post('/login', [AuthController::class, 'login']);
Route::Post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::post('/', [CourseController::class, 'store']);
        Route::get('/{id}', [CourseController::class, 'show']);
        Route::put('/{id}', [CourseController::class, 'update']);
        Route::delete('/{id}', [CourseController::class, 'destroy']);
    });

    Route::prefix('sections')->group(function () {
        Route::get('/', [SectionController::class, 'index']);
        Route::post('/', [SectionController::class, 'store']);
        Route::get('/{id}', [SectionController::class, 'show']);
        Route::put('/{id}', [SectionController::class, 'update']);
        Route::delete('/{id}', [SectionController::class, 'destroy']);
    });

    Route::prefix('elements')->group(function () {
        Route::get('/', [ElementController::class, 'index']);
        Route::post('/', [ElementController::class, 'store']);
        Route::get('/{id}', [ElementController::class, 'show']);
        Route::put('/{id}', [ElementController::class, 'update']);
        Route::delete('/{id}', [ElementController::class, 'destroy']);
    });
});