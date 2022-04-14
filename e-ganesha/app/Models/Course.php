<?php

namespace App\Models;

use App\Models\{Bab, User, ClassYear, TeacherCourse};
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};
use Spatie\Permission\Models\Role;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return "name";
    }

    public function classYear()
    {
        return $this->belongsTo(ClassYear::class, 'class_year_id');
    }

    public function bab()
    {
        return $this->belongsTo(Bab::class, 'bab_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacherCourse()
    {
        return $this->belongsTo(TeacherCourse::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
