<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // eloquentもでるはidカラムを参照するが、このテーブルのuser_idは既に一意制が保たれている。主キーを明示的に指定する必要がある
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'full_name',
        'telephone',
        'is_boss',
        'company_id',
    ];

    // public function user_login() :BelongsTo
    // {
    //     return $this->belongsTo(UserLogin::class, 'user_id');
    // }
    // public function user_login() :HasOne
    // {
    //     return $this->belongsTo(User::class);
    // }
    // public function userToCompany() :BelongsTo{
    //     return $this->belongsTo(Company::class);
    // }
    public function userLogin()
    {
        return $this->belongsTo(UserLogin::class, 'user_id');
    }
}
