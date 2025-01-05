<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SalarySlipComponents extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    // public function salaryStructures(): BelongsToMany
    // {
    //     return $this->belongsToMany(SalaryStructure::class, 'salary_slip_components');
    // }
}
