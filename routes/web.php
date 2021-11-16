<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

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
Route::get('student-list', [AdminController::class, 'studentList'])->name('student');
Route::get('teacher-list', [AdminController::class, 'teacherList'])->name('teacher');

Route::prefix('admin')->group(function (){
    Route::get('/', [AdminController::class, 'index']);
});

Route::prefix('student')->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::post('store', [StudentController::class, 'store'])->name('student.store');
});

Route::prefix('teacher')->group(function (){
    Route::get('/', [TeacherController::class, 'index']);
    Route::post('store', [TeacherController::class, 'store'])->name('teacher.store');
});


