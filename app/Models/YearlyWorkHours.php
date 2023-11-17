<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlyWorkHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'yearly_at',
        'worked_hours',
        'overwork'
    ];
}
