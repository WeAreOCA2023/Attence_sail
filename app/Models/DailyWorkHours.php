<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyWorkHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worked_at',
        'worked_hours',
        'break_time',
        'overwork'
    ];
}
