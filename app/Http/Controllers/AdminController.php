<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkRole');
    }

    public function index()
    {
        return view('admin.admin_dashboard');
    }

    public function studentList()
    {
        return 'student list to approve the profile';
    }

    public function teacherList(){
        return 'Teacher list to approve the profile';
    }
}
