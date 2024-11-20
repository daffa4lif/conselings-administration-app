<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeVisitController;
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

    Route::prefix("home-visits")->group(function () {
        Route::get('/', [HomeVisitController::class, 'index'])->name('home-visit.index');
        Route::get('/create', [HomeVisitController::class, 'create'])->name('home-visit.create');

        Route::get('/{id}', [HomeVisitController::class, 'detail'])->name('home-visit.detail');
    });

    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/create', [StudentController::class, 'create'])->name('student.create');
        Route::post('/create', [StudentController::class, 'createPost']);

        Route::get('/upload', [StudentController::class, 'upload'])->name('student.upload');
        Route::post('/upload', [StudentController::class, 'uploadPost']);

        Route::get('/{nis}', [StudentController::class, 'detail'])->name('student.detail');
        Route::post('/{nis}/new-classroom', [StudentController::class, 'createNewClassroomPost'])->name('student.create-new-classroom');
        Route::get('/delete-classroom/{id_student}/{id_class}/{year}', [StudentController::class, 'deleteClassroom'])->name('student.delete-classroom');
    });

    Route::prefix('classroom')->group(function () {
        Route::get('/', [ClassroomController::class, 'index'])->name('classroom.index');
        Route::post('/', [ClassroomController::class, 'createPost']);

        Route::get('/{id}', [ClassroomController::class, 'detail'])->name('classroom.detail');
        Route::post('/{id}', [ClassroomController::class, 'detailPost']);

        Route::get('/{id}/upload-students', [ClassroomController::class, 'registerStudentByUpload'])->name('classroom.upload');
        Route::post('/{id}/upload-students', [ClassroomController::class, 'registerStudentByUploadPost']);

        Route::get('delete/{id}', [ClassroomController::class, 'delete'])->name('classroom.delete');
    });

    Route::prefix("file")->group(function () {
        Route::post('upload', function (\Illuminate\Http\Request $request, \App\Services\FileUploadService $fileUploadService) {
            $upload = $fileUploadService->uploadTemp($request);

            return !$upload ? response()->json(status: 400, data: [
                'status' => 'error',
                'message' => 'file failed to upload'
            ]) : $upload;
        })->name('file.upload');
        Route::delete('revert', function (\Illuminate\Http\Request $request, \App\Services\FileUploadService $fileUploadService) {
            $revert = $fileUploadService->revertTemp($request);

            return $revert;
        })->name('file.revert');
    });
});