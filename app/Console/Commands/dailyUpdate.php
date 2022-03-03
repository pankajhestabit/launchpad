<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class dailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update admin on creation of student and teachers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $admin = User::where('role', 'Admin')->first()->toArray();
        $student = DB::table('users')
                        ->join('student_details','student_details.student_id','=','users.id')
                        ->where('student_details.status', 0)->get(); 
        $teacher = DB::table('users')
                    ->join('teacher_details','teacher_details.teacher_id','=','users.id')
                    ->where('teacher_details.status', 0)->get(); 

        $data = [
            'admin' => $admin,
            'students' => $student,
            'teachers' => $teacher
        ];

        Mail::send('emails.daily_update_email',$data,function($message) use ($data) {
            $message->to($data['admin']['email']);
            $message->subject('List of unapprove users');
        });
        return 'The list of unapprove users sent to Admin';
    }
}
