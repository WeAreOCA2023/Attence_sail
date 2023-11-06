<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
        'done_at',
    ];

    protected $attributes = [
        'title' => '',
        'description' => '',
        'status' => 1,
        'deadline' => null,
        'done_at' => null,
    ];

    public function userLogin()
    {
        return $this->belongsTo(UserLogin::class);
    }

    protected static function booted()
    {
        static::creating(function ($task) {
            $task->assigner_id = auth()->id();
        });
    }
}
