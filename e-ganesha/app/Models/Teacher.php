<?php

namespace App\Models;

use App\Models\Religion;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return "name";
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);;
    }
}
