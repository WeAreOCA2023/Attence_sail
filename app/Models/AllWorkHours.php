<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllWorkHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'weekly_total_work_hours',
        'monthly_total_work_hours',
        'yearly_total_work_hours',
        'total_over_work_hours',
    ];
}
