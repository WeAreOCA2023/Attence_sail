<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory;

    protected $fillable= [
        'department_name',
        'company_id',
        'responsible_id'
    ];

    public function getFromCompany() :HasOne{
        return $this->hasOne(Company::class);
    }
}
