<?php

namespace App\Http\Controllers;

use App\Events\SendApproval;
use App\Listeners\SendApprovalListener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StudentDetail;
use App\Models\TeacherDetail;
use App\Models\User;
use App\Models\AssignedTeacher;
use App\Notifications\assignStudentNotification;
use Exception;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole');
    }

    
    public function index()
    {
        return view('admin.admin_dashboard');
    }

    /*
    *  To show student list to approve profile
    */
    public function studentList()
    {
        $students = DB::table('users')
                    ->Join('student_details','student_details.student_id','=','users.id')
                    ->select('student_details.*','users.id as uid', 'users.email', 'users.name')
                    ->where('users.role', 'Student')
                    ->get();
                  
        return view('admin.student_list', ['students' => $students, 'sn' => 1]);
    }


    /*
    * To Approve student profile
    */
    public function studentApproval($id)
    {
        try {
            StudentDetail::where('student_id', $id)->update(['status' => 1]);
            event(new SendApproval($id)); // TO send email through event
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
        return redirect()->route('admin.student');
    }


    /*
    * Show teacher list to assign
    */
    public function assignStudent($id)
    {
        $teacher = User::find($id);
        $asList = array();

        $students = DB::table('users')
                    ->Join('student_details','student_details.student_id','=','users.id')
                    ->select('users.id', 'users.name', 'users.email', 'student_details.address', 'student_details.current_school', 'student_details.previous_school', 'student_details.parent_details', 'student_details.profile_picture')
                    ->where('users.role', 'Student')->where('student_details.status', 1)->get();
        
        $assignedStudent = DB::table('assigned_teachers')->select('student_id')->where('teachers', $id)->get();
        
        foreach($assignedStudent as $as){
            $asList[] = $as->student_id;
        }

        return view('admin.assign_student', ['teacher' => $teacher, 'students' => $students, 'asList' => $asList]); 
    }


    /*
    * Assign student to a teacher
    */
    public function assignStudentSave(Request $request)
    {
        $teacherId = $request->tid; // teacher Id

        try {

            foreach($request->students as $student){
                $count = AssignedTeacher::where('student_id', $student)->where('teachers', $teacherId)->count();
                if($count == 0){
                    $assignTeacher = new AssignedTeacher;
                    $assignTeacher->student_id = $student;
                    $assignTeacher->teachers = $teacherId;
                    $assignTeacher->save();   
                }
            }

            $user = User::find($teacherId);
            //
            Notification::send($user, new assignStudentNotification(['name' => 'Pankaj']));
            
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $request->session()->flash('success','Student Assigned');
        return redirect()->route('admin.teacher');
    }


    /*
    *  To view teacher list for approval
    */
    public function teacherList()
    {
        $teachers = DB::table('users')
                    ->join('teacher_details','teacher_details.teacher_id','=','users.id')
                    ->select('teacher_details.*', 'users.id as uid', 'users.email', 'users.name')
                    ->where('users.role', 'Teacher')->get();
                    
        return view('admin.teacher_list', ['teachers' => $teachers, 'sn' => 1]);
    }

    
    /*
    * To approve teacher
    */
    public function teacherApproval($id)
    {
        try {
            TeacherDetail::where('teacher_id',$id)->update(['status' => 1]); // To update teacher status as approved
            event(new SendApproval($id)); // TO send email through event
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
        return redirect()->route('admin.teacher');
    }
}
