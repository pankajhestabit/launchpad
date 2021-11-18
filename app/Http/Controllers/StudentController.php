<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkStudent');
    }


    // View student profile
    public function index()
    {
        $student = DB::table('users')
                    ->leftJoin('student_details','student_details.student_id','=','users.id')
                    ->select('student_details.*','users.email','users.name')
                    ->where('users.id', Auth::user()->id)->first();

        return view('student/student_dashboard', ['student' => $student]);
    }


    // To view assigned teacher list
    public function teacherList()
    {
        $teachers = DB::table('assigned_teachers')
                        ->join('teacher_details','teacher_details.teacher_id','=','assigned_teachers.teachers')
                        ->join('users','users.id','=','assigned_teachers.teachers')
                        ->where('assigned_teachers.student_id', Auth::user()->id)
                        ->select('teacher_details.*', 'users.name', 'users.email')->distinct('assigned_teachers.teachers')->get();
                         
        return view('student.assigned_teacher', ['teachers' => $teachers, 'sn' => 1]);
    }


    // To update profile of student
    public function store(Request $request){
        
        $uid = Auth::user()->id;

        // Validate user input
        $validate = $request->validate([
            'name' => 'required',
            'email' => ['required','email'],
            'address' => 'required',
            'pschool' => 'required',
            'cschool' => 'required',
            'pdetails' => 'required'
        ]);

        // Upload profile Picture
        if($request->hasFile('profilepic')){
            $path = $request->file('profilepic')->store('/public/students');
        }else{
            $path = $request->p_pic; // taking file path from hidden field
        }
         

        DB::beginTransaction();

        try {
            
            $check = DB::table('student_details')->where('student_id', $uid)->count();
            
            if($check > 0)
            { 
                DB::table('student_details')->where('student_id', $uid)->update([
                    'student_id' => $uid,
                    'address' => $request->address,
                    'profile_picture' => str_replace('public','',$path),
                    'current_school' => $request->cschool,
                    'previous_school' => $request->pschool,
                    'parent_details' => $request->pdetails
                    ]);
            }else{
                //return $request->all();
                DB::table('student_details')->insert([
                    'student_id' => $uid,
                    'address' => $request->address,
                    'profile_picture' => str_replace('public','',$path),
                    'current_school' => $request->cschool,
                    'previous_school' => $request->pschool,
                    'parent_details' => $request->pdetails,
                    'status' => 0
                    ]);
            }
            
            DB::table('users')->where('id', $uid)->update([
                'name' => $request->name
            ]);
            
            DB::commit();
        
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }

         $request->session()->flash('success','Profile Info Updated');
         return redirect('student');

    }

}
