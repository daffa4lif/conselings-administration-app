<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost']);
});

// auth path
Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        return view('index');
    });

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/create', [StudentController::class, 'create'])->name('student.create');
        Route::post('/create', [StudentController::class, 'createPost']);

        Route::get('/upload', [StudentController::class, 'upload'])->name('student.upload');
        Route::post('/upload', [StudentController::class, 'upload']);

        Route::get('/{nis}', [StudentController::class, 'detail'])->name('student.detail');
        Route::post('/{nis}/new-classroom', [StudentController::class, 'createNewClassroomPost'])->name('student.create-new-classroom');
        Route::get('/delete-classroom/{id_student}/{id_class}/{year}', [StudentController::class, 'deleteClassroom'])->name('student.delete-classroom');
    });
});