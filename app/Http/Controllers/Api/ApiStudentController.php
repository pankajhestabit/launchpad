<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentDetail;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiStudentController extends Controller
{

    /*
    * Display a listing of the resource.
    */
    public function index()
    {
        $students = DB::table('users')
                    ->Join('student_details','student_details.student_id','=','users.id')
                    ->select('users.id', 'users.name', 'users.email', 'student_details.address', 'student_details.current_school', 'student_details.previous_school', 'student_details.parent_details', 'student_details.profile_picture')
                    ->where('users.role', 'Student')->get();

        return response()->json(['success' => true, 'data' => $students], 200);
    }



    /**
    * Store a newly created resource in storage.
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
        $input['role'] = 'Student';

        $students = User::create($input);

        StudentDetail::create([
            'student_id' => $students->id,
            'status' => 0
        ]);
        
        return response()->json([
            "success" => true,
            "message" => "Student created successfully.",
            "data" => $students
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = DB::table('users')
                    ->leftJoin('student_details','student_details.student_id','=','users.id')
                    ->select('users.id', 'users.name', 'users.email', 'student_details.address', 'student_details.current_school', 'student_details.previous_school', 'student_details.parent_details', 'student_details.profile_picture')
                    ->where('users.id', $id)->first();
        return response()->json(['success' => true, 'data' => $student], 200);
    }

   

    /**
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
            'parent_details' => 'required',
        ]); 
        
        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()], 401);        
        }

        DB::beginTransaction();

        try {
             
            DB::table('student_details')->where('student_id', $id)->update([
                'address' => $request->address,
                'profile_picture' => '',
                'current_school' => $request->current_school,
                'previous_school' => $request->previous_school,
                'parent_details' => $request->parent_details
            ]);

            DB::table('users')->where('id', $id)->update([
                'name' => $request->name
            ]);
            
            DB::commit();
        
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error'=> $e->getMessage()], 401); 
        }

        return response()->json(['success' => true, 'data' => 'Student updated'], 200);
    }


    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            User::where('id', $id)->delete();
            StudentDetail::where('student_id', $id)->delete();
            
            DB::commit();
        
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error'=> $e->getMessage()], 401);
        }
        
        return response()->json(['success'=> true, 'message' => 'Student deleted'], 200);
    }
}
