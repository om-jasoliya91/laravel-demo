<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'role', 'age', 'city', 'address', 'password', 'profile_pic',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
