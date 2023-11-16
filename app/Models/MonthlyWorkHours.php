<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyWorkHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'monthly_at',
        'worked_hours',
    ];
}
