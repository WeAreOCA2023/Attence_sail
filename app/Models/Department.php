<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';

    protected $fillable= [
        'department_name',
        'company_id',
        'boss_id'
    ];

//    public function getFromCompany() :HasOne{
//        return $this->hasOne(Company::class);
//    }
}
