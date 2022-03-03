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
        $this->middleware('checkTeacher'); // To check user role is teacher
    }
    

    // To get teacher profile
    public function index()
    {
        $teacher = User::find(Auth::user()->id);
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
        $id = Auth::user()->id;

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
             
            DB::table('teacher_details')->where('teacher_id', $id)->update([
                'address' => $request->address,
                'profile_picture' => str_replace('public','',$path),
                'current_school' => $request->cschool,
                'previous_school' => $request->pschool,
                'experience' => $request->experience
            ]);
            
            DB::table('users')->where('id', $id)->update([
                'name' => $request->name
            ]);

            DB::commit();
        
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e->getMessage()]);
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
