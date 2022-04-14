<?php

namespace App\Models;

use App\Models\TeacherCourse;
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Bab extends Model
{
    use HasFactory;

    public function teacherCourse()
    {
        return $this->belongsTo(TeacherCourse::class, 'teacher_course_id');
    }
}
