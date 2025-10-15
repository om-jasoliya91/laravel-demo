<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description', 'duration', 'price', 'status'];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'enrollments')
            ->withPivot('status')
            ->withTimestamps();
    }
}
