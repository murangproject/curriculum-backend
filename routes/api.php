<?php

use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum'], 'excluded_middleware' => 'throttle:api'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/check-role', [AuthController::class, 'checkRole']);

    // Users
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/active', [UserController::class, 'active']);
    Route::get('/users/invited', [UserController::class, 'invited']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::put('/users/{id}', [UserController::class, 'update']);

    // validate token
    Route::get('/validate-token', function () {
        return response()->json(['message' => 'Token is valid']);
    });

    // Curent user
    Route::get('/current', [UserController::class, 'current']);
    Route::post('/init', [UserController::class, 'init']);
    Route::put('/profile/{id}', [UserController::class, 'updateProfile']);

    // Department
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::get('/departments/archives', [DepartmentController::class, 'archives']);
    Route::put('/departments/restore/{id}', [DepartmentController::class, 'restore']);
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::get('/departments/{id}', [DepartmentController::class, 'show']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);

    // Academic year
    Route::get('/academic-years', [AcademicYearController::class, 'index']);
    Route::post('/academic-years', [AcademicYearController::class, 'store']);
    Route::get('/academic-years/{id}', [AcademicYearController::class, 'show']);
    Route::put('/academic-years/{id}', [AcademicYearController::class, 'update']);
    Route::delete('/academic-years/{id}', [AcademicYearController::class, 'destroy']);

    // Term
    Route::get('/terms', [TermController::class, 'index']);
    Route::post('/terms', [TermController::class, 'store']);
    Route::get('/terms/{id}', [TermController::class, 'show']);
    Route::put('/terms/{id}', [TermController::class, 'update']);
    Route::delete('/terms/{id}', [TermController::class, 'destroy']);

    // Subject
    Route::get('/subjects', [SubjectController::class, 'index']);
    Route::post('/subjects', [SubjectController::class, 'store']);
    Route::get('/subjects/{code}', [SubjectController::class, 'show']);
    Route::put('/subjects/{code}', [SubjectController::class, 'update']);
    Route::delete('/subjects/{code}', [SubjectController::class, 'destroy']);
    Route::post('/subjects/{code}/syllabus', [SubjectController::class, 'uploadSyllabus']);

    // Curriculum
    Route::get('/curriculums', [CurriculumController::class, 'index']);
    Route::post('/curriculums', [CurriculumController::class, 'store']);
    Route::get('/curriculums/{id}', [CurriculumController::class, 'show']);
    Route::put('/curriculums/{id}', [CurriculumController::class, 'update']);
    Route::delete('/curriculums/{id}', [CurriculumController::class, 'destroy']);
    Route::get('/curriculums/{id}/subjects', [CurriculumController::class, 'getCurriculumWithSubjects']);
    Route::post('/curriculums/{id}/subjects', [CurriculumController::class, 'addSubjectsToCurriculum']);
    Route::delete('/curriculums/{id}/subjects', [CurriculumController::class, 'removeSubjectsFromCurriculum']);
    Route::put('/curriculums/{id}/status', [CurriculumController::class, 'updateStatus']);

    // Comments
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/comments/{id}', [CommentController::class, 'show']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

    // Activities
    Route::get('/activities', [ActivityController::class, 'index']);
    Route::post('/activities', [ActivityController::class, 'show']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
