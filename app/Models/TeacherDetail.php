<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherDetail extends Model
{
    use HasFactory;
    protected $table = 'teacher_details';

    protected $fillable = [
        'teacher_id',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
