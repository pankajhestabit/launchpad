<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TeacherSubject;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkTeacher');
    }
    

    // To Find teacher profile data
    public function index()
    {
        $teacher = DB::table('users')
                    ->leftJoin('teacher_details','teacher_details.teacher_id','=','users.id')
                    ->select('teacher_details.*','users.email','users.name')
                    ->where('users.id', Auth::user()->id)->first();
        
        return view('teacher.teacher_dashboard', ['teacher' => $teacher]);
    }



    // To add subjects to a perticular teacher
    public function subject()
    {
        $subjects = TeacherSubject::where('teacher_id', Auth::user()->id)->get();
        return view('teacher.add_subject', ['subjects' => $subjects]);
    }



    public function addSubject(Request $request)
    {
        $tid = Auth::user()->id;

        $count = TeacherSubject::where('teacher_id', $tid)->where('subject', $request->subject)->count();
        if($count == 0){
            $subject = new TeacherSubject;
            $subject->teacher_id = $tid;
            $subject->subject = $request->subject;
            $subject->save();
            $request->session()->flash('success', 'Subject added');
        }else{
            $request->session()->flash('success', 'Exist');
        }
        
        return redirect()->route('teacher.subject');
    }



    // Add profile information into the database
    public function store(Request $request){
        $uid = Auth::user()->id;

        // Validate user input
        $validate = $request->validate([
            'name' => 'required',
            'email' => ['required','email'],
            'address' => 'required',
            'pschool' => 'required',
            'cschool' => 'required',
            'experience' => 'required'
        ]);

         
        // Upload profile Picture
        if($request->hasFile('profilepic')){
            $path = $request->file('profilepic')->store('/public/teachers');
        }else{
            $path = $request->p_pic; // taking file path from hidden field
        }
         
        
        DB::beginTransaction();

        try {
        
            $check = DB::table('teacher_details')->where('teacher_id', $uid)->count();
            
            if($check > 0)
            { 
                DB::table('teacher_details')->where('teacher_id', $uid)->update([
                    'address' => $request->address,
                    'profile_picture' => str_replace('public','',$path),
                    'current_school' => $request->cschool,
                    'previous_school' => $request->pschool,
                    'experience' => $request->experience
                    ]);
            }else{

                DB::table('teacher_details')->insert([
                    'teacher_id' => $uid,
                    'address' => $request->address,
                    'profile_picture' => '',
                    'current_school' => $request->cschool,
                    'previous_school' => $request->pschool,
                    'experience' => $request->experience,
                    'status' => 0
                    ]);
            }
            
            DB::table('users')->where('id', $uid)->update([
                'name' => $request->name
            ]);

            DB::commit();
        
        } catch (Exception $e) {
            DB::rollBack();
        }

         $request->session()->flash('success','Profile Info Updated');
         return redirect('teacher');
    }


    public function markAsReadTeacher(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->route('teacher.studentlist');
    }

    public function studentList()
    {
        $students = DB::table('assigned_teachers')
                        ->join('student_details','student_details.student_id','=','assigned_teachers.student_id')
                        ->join('users','users.id','=','assigned_teachers.student_id')
                        ->where('assigned_teachers.teachers', Auth::user()->id)
                        ->select('student_details.*', 'users.name', 'users.email')->distinct('assigned_teachers.student_id')->get();
                         
        return view('teacher.assigned_student', ['students' => $students, 'sn' => 1]);
    }
}
