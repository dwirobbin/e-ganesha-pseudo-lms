<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    RoleController,
    LoginController,
    StudentController,
    TeacherController,
    ClassYearController,
    CourseController,
    DashboardController,
    LogActivityController,
    ProfileStudentController,
    StudentCourseController,
    TeacherCourseController
};

// Home
Route::get('/', fn () => view('frontend.index', ['title' => 'Home']));

// Authentication
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// Dashboard/Admin
Route::get('/dashboard/admin', [DashboardController::class, '__invoke'])->middleware('auth');

// Dashboard/Admin/Roles
Route::prefix('/dashboard/admin/roles')->group(function () {
    Route::get('/', [RoleController::class, 'index']);
    Route::get('/{role:name}', [RoleController::class, 'show']);
    Route::get('/{role:name}/edit', [RoleController::class, 'edit']);
    Route::put('/{role:name}/update', [RoleController::class, 'update']);
});

// Dashboard/Admin/Teachers
Route::resource('/dashboard/admin/teachers', TeacherController::class);

// Dashboard/Admin/Students
Route::resource('/dashboard/admin/students', StudentController::class);

// Dashboard/Admin/ClassYear
Route::prefix('/dashboard/admin/class-years')->group(function () {
    Route::get('/', [ClassYearController::class, 'index']);
    Route::get('/create', [ClassYearController::class, 'create']);
    Route::post('/store', [ClassYearController::class, 'store']);
    Route::delete('/{classYear:name}/delete', [ClassYearController::class, 'destroy']);
});

// Dashboard/Admin/Courses
Route::get('/dashboard/admin/courses', [CourseController::class, '__invoke'])->middleware('auth');

// Dashboard/Admin/Log Activities
Route::prefix('/dashboard/admin/logs-activity')->group(function () {
    Route::get('/', [LogActivityController::class, 'index']);
    Route::delete('/{description}/delete', [LogActivityController::class, 'destroy']);
});

// Dashboard/TeacherCourse
Route::prefix('/dashboard/courses')->group(function () {
    Route::get('/', [TeacherCourseController::class, 'index']);
    Route::get('/create', [TeacherCourseController::class, 'create']);
    Route::post('/store', [TeacherCourseController::class, 'store']);
    Route::get('/{teacherCourse:name}', [TeacherCourseController::class, 'show']);
    Route::get('/{teacherCourse:name}/edit', [TeacherCourseController::class, 'editCourse']);
    Route::put('/{teacherCourse:name}/update', [TeacherCourseController::class, 'updateCourse']);
    Route::delete('/{teacherCourse:name}/delete', [TeacherCourseController::class, 'destroyCourse']);
    Route::get('/{teacherCourse:name}/create', [TeacherCourseController::class, 'detailCreate']);
    Route::delete('/{course:id}/delete-bab', [TeacherCourseController::class, 'deleteBab']);
    Route::get('/{course:id}/edit-bab', [TeacherCourseController::class, 'editBab']);
    Route::put('/{id}/update-bab', [TeacherCourseController::class, 'updateBab']);
    Route::post('/{teacherCourse:name}/store', [TeacherCourseController::class, 'detailStore']);
    Route::get('/{teacherCourse:name}/show', [TeacherCourseController::class, 'detailCourse']);
    Route::get('/done-upload-answers/{id}', [TeacherCourseController::class, 'seeUploadAnswer']);

    // Upload File from Student
    Route::post('/{teacherCourse:name}/{id}/student/uploadFile', [StudentCourseController::class, 'storeFile'])->middleware('auth');
});

// Download file .pdf
Route::get('/download/{file_name}', [TeacherCourseController::class, 'downloadFile']);

// Download file answer student
Route::get('/download-answer/{file_name}', [TeacherCourseController::class, 'downloadFileAnswer']);

// Dashboard/Student/profile_siswa
Route::get('/dashboard/student/profile-siswa', [ProfileStudentController::class, 'index']);
Route::put('/dashboard/student/profile-siswa/{student:name}', [ProfileStudentController::class, 'saveImgProfile']);

// Dashboard/Student/profile_statistik_siswa
Route::get('/dashboard/student/profile-statistik-siswa/{id}', [ProfileStudentController::class, 'profileStatistik']);
