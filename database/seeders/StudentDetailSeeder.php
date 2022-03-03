<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('student_details')->insert([
            'student_id' => rand(1,10),
            'address' => Str::random(10),
            'profile_picture' => Str::random(10),
            'current_school' => Str::random(10),
            'previous_school' => Str::random(10),
            'parent_details' => Str::random(10),
            'status' => 0
        ]);
    }
}
