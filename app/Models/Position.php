<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'position_name',
        'company_id',
        'rank',
    ];

    public function positionToCompany(): BelongsTo{
        return $this->belongsTo(Company::class);
    }
}
