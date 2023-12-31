<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyWorkHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'weekly_at',
        'worked_hours',
        'overwork'
    ];
}
