<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSubject extends Model
{
    use HasFactory;
    protected $table = 'teacher_subjects';

    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
