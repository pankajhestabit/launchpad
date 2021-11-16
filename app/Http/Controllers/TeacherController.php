<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkTeacher');
    }
    
    public function index()
    {
        $user = DB::table('users')
                    ->leftJoin('teacher_details','teacher_details.teacher_id','=','users.id')
                    ->select('teacher_details.*','users.email','users.name')
                    ->where('users.id', Auth::user()->id)->first();
        
        return view('teacher.teacher_dashboard', ['user' => $user]);
    }


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
         
         DB::table('teacher_details')->where('id', 1)->update([
            'teacher_id' => $uid,
            'address' => $request->address,
            'profile_picture' => str_replace('public','',$path),
            'current_school' => $request->cschool,
            'previous_school' => $request->pschool,
            'experience' => $request->experience
         ]);

         DB::beginTransaction();

         try {
            
            DB::table('teacher_details')->where('id', 1)->update([
                'teacher_id' => $uid,
                'address' => $request->address,
                'profile_picture' => str_replace('public','',$path),
                'current_school' => $request->cschool,
                'previous_school' => $request->pschool,
                'experience' => $request->experience
             ]);

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
}
