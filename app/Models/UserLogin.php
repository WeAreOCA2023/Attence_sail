<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'password',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];
}
