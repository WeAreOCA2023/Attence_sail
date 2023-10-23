<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_code',
        'company_name',
        'company_password',
        'post_code',
        'address',
    ];

    protected $hidden = [
        'company_password',
    ];

    protected $casts = [
        'company_password' => 'hashed',
    ];
    // public function companyToDepartment(): BelongsTo
    // {
    //     return $this->belongsTo(Department::class);
    // }

    // public function companyGiveToUser():HasOne{
    //     return $this->hasOne(User::class);
    // }

    // public function companyGiveToPosition(): HasMany{
    //     return $this->hasMany(Position::class);
    // }

    // public function company(): HasMany
    // {
    //     return $this->hasMany(Position::class);
    // }
}
