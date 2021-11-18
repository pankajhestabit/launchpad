<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentDetail;
use App\Models\TeacherDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiTeacherController extends Controller
{

    /*
    * Display a listing of the teacher.
    */
    public function index()
    {
        $teachers = DB::table('users')
                        ->Join('teacher_details','teacher_details.teacher_id','=','users.id')
                        ->select('users.id', 'users.name', 'users.email', 'teacher_details.address', 'teacher_details.current_school', 'teacher_details.previous_school', 'teacher_details.experience')
                        ->where('users.role', 'Teacher')->get();

        return response()->json(['success' => true, 'data' => $teachers], 200);
    }



    /*
    * Store a teacher
    */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 'Teacher';

        $teacher = User::create($input);
        
        return response()->json([
            "success" => true,
            "message" => "Teacher created successfully.",
            "data" => $teacher
        ]);
    }


    /*
    * Display the specified teacher details.
    */
    public function show($id)
    {
        $teacher = DB::table('users')
                    ->leftJoin('teacher_details','teacher_details.teacher_id','=','users.id')
                    ->select('users.id', 'users.name', 'users.email', 'teacher_details.address', 'teacher_details.current_school', 'teacher_details.previous_school', 'teacher_details.experience')
                    ->where('users.id', $id)->where('users.role', 'Teacher')->first();
        return response()->json(['success' => true, 'data' => $teacher], 200);
    }
   

    /*
    * Update the specified resource in storage.
    */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'address' => 'required',
            'previous_school' => 'required',
            'current_school' => 'required',
            'experience' => 'required',
        ]); 
        
        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 401);        
        }

        DB::beginTransaction();

        try {
            
            $check = DB::table('teacher_details')->where('teacher_id', $id)->count();
            
            if($check > 0)
            { 
                DB::table('teacher_details')->where('teacher_id', $id)->update([
                    'address' => $request->address,
                    'profile_picture' => '',
                    'current_school' => $request->current_school,
                    'previous_school' => $request->previous_school,
                    'experience' => $request->experience
                    ]);
            }else{
                
                DB::table('teacher_details')->insert([
                    'teacher_id' => $id,
                    'address' => $request->address,
                    'profile_picture' => '',
                    'current_school' => $request->current_school,
                    'previous_school' => $request->previous_school,
                    'experience' => $request->experience,
                    'status' => 0
                    ]);
            }
            
            DB::table('users')->where('id', $id)->update([
                'name' => $request->name
            ]);
            
            DB::commit();
        
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error'=> $e->getMessage()], 401); 
        }

        return response()->json(['success' => true, 'data' => 'Teacher updated'], 200);
    }


    /*
    * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            User::where('id', $id)->delete();
            TeacherDetail::where('teacher_id', $id)->delete();
            
            DB::commit();
        
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error'=> $th->getMessage()], 401);
        }
        
        return response()->json(['success'=> true, 'message' => 'Teacher deleted'], 200);
    }
}
