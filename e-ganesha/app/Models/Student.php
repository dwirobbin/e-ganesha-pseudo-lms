<?php

namespace App\Models;

use App\Models\{Gender, Religion, ClassYear};
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function classYear()
    {
        return $this->belongsTo(ClassYear::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
