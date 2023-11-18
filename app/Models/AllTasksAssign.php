<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllTasksAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignee_id',
        'task_id',
        'assigned_at',
    ];
}
