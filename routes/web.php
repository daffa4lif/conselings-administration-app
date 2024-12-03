<?php

use App\Http\Controllers\AbsentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ConselingController;
use App\Http\Controllers\ConselingGrupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeVisitController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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

    Route::get('/', [DashboardController::class, "index"])->name("dashboard");

    Route::middleware('permission: list home visit')->prefix("home-visits")->group(function () {
        Route::get('/', [HomeVisitController::class, 'index'])->name('home-visit.index');
        Route::get('/{id}', [HomeVisitController::class, 'detail'])->name('home-visit.detail');

        Route::middleware('permission: crud home visit')->group(function () {
            Route::get('/create', [HomeVisitController::class, 'create'])->name('home-visit.create');
            Route::post('/create', [HomeVisitController::class, 'createPost']);
            Route::post('/{id}', [HomeVisitController::class, 'detailPost']);
            Route::get('/{id}/delete', [HomeVisitController::class, 'delete'])->name('home-visit.delete');
        });
    });

    Route::middleware('permission: list student')->prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('student.index');
        Route::get('/{nis}', [StudentController::class, 'detail'])->name('student.detail');

        Route::middleware('permission: crud student')->group(function () {
            Route::get('/create', [StudentController::class, 'create'])->name('student.create');
            Route::post('/create', [StudentController::class, 'createPost']);
            Route::get('/upload', [StudentController::class, 'upload'])->name('student.upload');
            Route::post('/upload', [StudentController::class, 'uploadPost']);
            Route::post('/{nis}', [StudentController::class, 'detailPost']);
            Route::post('/{nis}/new-classroom', [StudentController::class, 'createNewClassroomPost'])->name('student.create-new-classroom');
            Route::get('/delete-classroom/{id_student}/{id_class}/{year}', [StudentController::class, 'deleteClassroom'])->name('student.delete-classroom');
        });
    });

    Route::middleware('permission: list classroom')->prefix('classroom')->group(function () {
        Route::get('/', [ClassroomController::class, 'index'])->name('classroom.index');
        Route::get('/{id}', [ClassroomController::class, 'detail'])->name('classroom.detail');

        Route::middleware('permission: crud classroom')->group(function () {
            Route::post('/', [ClassroomController::class, 'createPost']);
            Route::post('/{id}', [ClassroomController::class, 'detailPost']);

            Route::get('/{id}/upload-students', [ClassroomController::class, 'registerStudentByUpload'])->name('classroom.upload');
            Route::post('/{id}/upload-students', [ClassroomController::class, 'registerStudentByUploadPost']);

            Route::get('delete/{id}', [ClassroomController::class, 'delete'])->name('classroom.delete');
        });
    });

    Route::middleware('permission: list classroom')->prefix('major')->group(function () {
        Route::get('/', [MajorController::class, 'index'])->name('major.index');
        Route::get('/{id}', [MajorController::class, 'detail'])->name('major.detail');

        Route::middleware('permission: crud classroom')->group(function () {
            Route::post('/', [MajorController::class, 'createPost']);
            Route::post('/{id}', [MajorController::class, 'detailPost']);
            Route::get('/{id}/delete', [MajorController::class, 'delete'])->name('major.delete');
        });
    });

    Route::middleware('permission: list absent')->prefix("absents")->group(function () {
        Route::get("/", [AbsentController::class, "index"])->name("absent.index");
        Route::get("/{id}", [AbsentController::class, "detail"])->name("absent.detail");

        Route::middleware('permission: crud absent')->group(function () {
            Route::get("/create", [AbsentController::class, "create"])->name("absent.create");
            Route::post("/create", [AbsentController::class, "createPost"]);

            Route::get("/upload", [AbsentController::class, "upload"])->name("absent.upload");
            Route::post("/upload", [AbsentController::class, "uploadPost"]);

            Route::post("/{id}", [AbsentController::class, "detailPost"]);

            Route::get("/{id}/delete", [AbsentController::class, "delete"])->name("absent.delete");
        });
    });

    Route::middleware('permission: list cases')->prefix('cases')->group(function () {
        Route::get('/', [CaseController::class, 'index'])->name('case.index');
        Route::get('/{id}', [CaseController::class, 'detail'])->name('case.detail');

        Route::middleware('permission: crud cases')->group(function () {
            Route::get('/create', [CaseController::class, 'create'])->name('case.create');
            Route::post('/create', [CaseController::class, 'createPost']);

            Route::post('/{id}', [CaseController::class, 'DetailPost']);

            Route::get('/{id}/delete', [CaseController::class, 'delete'])->name('case.delete');
        });
    });

    Route::middleware('permission: list conseling')->prefix("conselings")->group(function () {
        Route::get('/', [ConselingController::class, 'index'])->name('conseling.index');
        Route::get('/{id}', [ConselingController::class, 'detail'])->name('conseling.detail');

        Route::middleware('permission: crud conseling')->group(function () {
            Route::get('/create', [ConselingController::class, 'create'])->name('conseling.create');
            Route::post('/create', [ConselingController::class, 'createPost']);

            Route::post('/{id}', [ConselingController::class, 'detailPost']);

            Route::get('/{id}/delete', [ConselingController::class, 'delete'])->name('conseling.delete');
        });
    });

    Route::middleware('permission: list conseling')->prefix("conselings-group")->group(function () {
        Route::get('/', [ConselingGrupController::class, 'index'])->name('conseling-group.index');
        Route::get('/{id}', [ConselingGrupController::class, 'detail'])->name('conseling-group.detail');

        Route::middleware('permission: crud conseling')->group(function () {
            Route::get('/create', [ConselingGrupController::class, 'create'])->name('conseling-group.create');
            Route::post('/create', [ConselingGrupController::class, 'createPost']);

            Route::post('/{id}', [ConselingGrupController::class, 'detailPost']);

            Route::get('/{id}/delete', [ConselingGrupController::class, 'delete'])->name('conseling-group.delete');
        });
    });

    Route::middleware('permission: list reports')->prefix("reports")->group(function () {
        Route::prefix("absents")->group(function () {
            Route::get('/', [ReportController::class, "indexAbsents"])->name("report.absent");
            Route::get('/print', [ReportController::class, "printAbsents"])->name("report.absent.print");
        });

        Route::prefix("cases")->group(function () {
            Route::get('/', [ReportController::class, "indexCases"])->name("report.case");
            Route::get('/print', [ReportController::class, "printCasesStudent"])->name("report.case.print");
        });

        Route::prefix("home-visits")->group(function () {
            Route::get('/', [ReportController::class, "indexHomeVisits"])->name("report.visit");
            Route::get('/print', [ReportController::class, "printHomeVisits"])->name("report.visit.print");
        });

        Route::prefix("conselings")->group(function () {
            Route::get('/', [ReportController::class, "indexConselings"])->name("report.conseling");
            Route::get('/print', [ReportController::class, "printConselings"])->name("report.conseling.print");
        });

        Route::prefix("conselings-group")->group(function () {
            Route::get('/', [ReportController::class, "indexConselingsGroup"])->name("report.conseling-group");
            Route::get('/print', [ReportController::class, "printConselingsGroup"])->name("report.conseling-group.print");
        });
    });

    Route::middleware('permission:list user staff, list user student')->prefix('master')->group(function () {
        Route::prefix("users")->group(function () {
            Route::prefix("staff")->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('master.user.index');

                Route::middleware('permission: crud user staff')->group(function () {
                    Route::get('/create', [UserController::class, 'create'])->name('master.user.create');
                    Route::post('/create', [UserController::class, 'createPost']);

                    Route::get('/{id}', [UserController::class, 'detail'])->name('master.user.detail');
                    Route::post('/{id}', [UserController::class, 'detailPost']);

                    Route::get('/{id}/delete', [UserController::class, 'delete'])->name('master.user.delete');
                });
            });

            Route::prefix("student")->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('master.user.index');

                Route::middleware('permission: crud user student')->group(function () {
                    Route::get('/create', [UserController::class, 'create'])->name('master.user.create');
                    Route::post('/create', [UserController::class, 'createPost']);

                    Route::get('/{id}', [UserController::class, 'detail'])->name('master.user.detail');
                    Route::post('/{id}', [UserController::class, 'detailPost']);

                    Route::get('/{id}/delete', [UserController::class, 'delete'])->name('master.user.delete');
                });
            });
        });
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

// Is Not Secure for production
Route::get('/api/students', [StudentController::class, "searchStudents"])->name("student.api.search");