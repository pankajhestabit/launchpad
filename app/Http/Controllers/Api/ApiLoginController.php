<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\StudentDetail;
use App\Models\TeacherDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiLoginController extends Controller
{
    
    public $successStatus = 200;
    

    /* 
    * Login api 
    */ 
    
    public function login(Request $request){ 
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('myApp')-> accessToken; 
            $success['Name'] =  $user->name;
            $success['Role'] =  $user->role;
   
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }


    /*
    * Register api 
    */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required',
            'role' => 'required', 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input);
        
        if($input['role'] == 'Student'){
            StudentDetail::create([
                'student_id' => $user->id,
                'status' => 0
            ]);
        }else{
            TeacherDetail::create([
                'teacher_id' => $user->id,
                'status' => 0
            ]);
        }
        
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;

        return response()->json(['success' => $success], $this-> successStatus); 
    }
    


    /** 
    * details api 
    */ 
    public function studentProfile() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 
}
