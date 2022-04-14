<?php

namespace App\Models;

use App\Models\{Bab, User, Course, ClassYear, TeacherCourse};
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class UploadAnswer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function teacherCourse()
    {
        return $this->belongsTo(TeacherCourse::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classYear()
    {
        return $this->belongsTo(ClassYear::class);
    }

    public function bab()
    {
        return $this->belongsTo(Bab::class);
    }
}
