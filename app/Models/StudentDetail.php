<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDetail extends Model
{
    use HasFactory;
    protected $table = 'student_details';


    public function user(){
        return $this->belongsTo(User::class, 'student_id');
    }

}
