<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teacher_details')->insert([
            'teacher_id' => rand(1,100),
            'address' => Str::random(10),
            'profile_picture' => Str::random(10),
            'previous_school' => Str::random(10),
            'current_school' => Str::random(10),
            'experience' => Str::random(10),
            'status' => 0
        ]);
    }
}
