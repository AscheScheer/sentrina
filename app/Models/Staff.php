<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory; //

class Staff extends Authenticatable
{
use HasFactory, Notifiable;

    protected $table = 'staff'; // optional, since Laravel expects 'staff' not 'staffs'

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

// \App\Models\Staff::factory()->create();
