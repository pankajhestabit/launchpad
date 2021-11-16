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
        $this->middleware('checkStudent');
    }

    public function index()
    {
        $user = DB::table('users')
                    ->leftJoin('student_details','student_details.student_id','=','users.id')
                    ->select('student_details.*','users.email','users.name')
                    ->where('users.id', Auth::user()->id)->first();

        return view('student/student_dashboard', ['user' => $user]);
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
            
            DB::table('users')->where('id', $uid)->update([
                'name' => $request->name
            ]);
            
            DB::table('student_details')->where('id', 1)->updateOrInsert([
                'student_id' => $uid,
                'address' => $request->address,
                'profile_picture' => str_replace('public','',$path),
                'current_school' => $request->cschool,
                'previous_school' => $request->pschool,
                'parent_details' => $request->pdetails
             ]);

             DB::commit();
         
         } catch (Exception $e) {
             DB::rollBack();
         }

         $request->session()->flash('success','Profile Info Updated');
         return redirect('student');

    }

}
