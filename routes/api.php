<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CertificationController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ElementController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\UserController;
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
    
    Route::post('/sign-to-course', [CourseController::class, 'signInToCourse']);

    Route::prefix('certifications')->group(function () {
        Route::get('/', [CertificationController::class, 'index']);
        Route::post('/', [CertificationController::class, 'store']);
        Route::get('/{id}', [CertificationController::class, 'show']);
        Route::put('/{id}', [CertificationController::class, 'update']);
        Route::delete('/{id}', [CertificationController::class, 'destroy']);
        Route::post('/{id}/assign-courses', [CertificationController::class, 'assignCourses']);
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
        Route::post('/progress', [ElementController::class, 'progress']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('options')->group(function () {
        Route::get('/', [OptionController::class, 'index']);
        Route::post('/', [OptionController::class, 'store']);
        Route::get('/{id}', [OptionController::class, 'show']);
        Route::put('/{id}', [OptionController::class, 'update']);
        Route::delete('/{id}', [OptionController::class, 'destroy']);
    });

    Route::prefix('questions')->group(function () {
        Route::get('/', [QuestionController::class, 'index']);
        Route::post('/', [QuestionController::class, 'store']);
        Route::get('/{id}', [QuestionController::class, 'show']);
        Route::put('/{id}', [QuestionController::class, 'update']);
        Route::delete('/{id}', [QuestionController::class, 'destroy']);
    });
});