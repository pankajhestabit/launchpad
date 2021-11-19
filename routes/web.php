<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()){
        return redirect('home');
    }else{
        return redirect('/login');
    }
});

Auth::routes(['reset' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function (){
    Route::get('/', [AdminController::class, 'index']);
    Route::get('student-list', [AdminController::class, 'studentList'])->name('admin.student');
    Route::get('teacher-list', [AdminController::class, 'teacherList'])->name('admin.teacher');
    Route::get('approve-student/{id}', [AdminController::class, 'studentApproval'])->name('admin.sapprove');
    Route::get('assign-student/{id}', [AdminController::class, 'assignStudent'])->name('admin.assign_student');
    Route::post('assign-student-store', [AdminController::class, 'assignStudentSave'])->name('admin.assignStudentSave');

    Route::get('approve-teacher/{id}', [AdminController::class, 'teacherApproval'])->name('admin.tapprove');

    Route::get('mark-as-read', [AdminController::class, 'markAsRead'])->name('admin.mark');
});

Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('store', [StudentController::class, 'store'])->name('student.store');
    Route::get('teacher-list', [StudentController::class, 'teacherList'])->name('student.teacherlist');
});

Route::prefix('teacher')->group(function (){
    Route::get('/', [TeacherController::class, 'index']);
    Route::post('store', [TeacherController::class, 'store'])->name('teacher.store');
    Route::get('subject', [TeacherController::class, 'subject'])->name('teacher.subject');
    Route::post('subject-store', [TeacherController::class, 'addSubject'])->name('teacher.addsubject');
    Route::get('student-list', [TeacherController::class, 'studentList'])->name('teacher.studentlist');
    Route::get('mark-as-read-teacher', [TeacherController::class, 'markAsReadTeacher'])->name('teacher.markteacher');
});


