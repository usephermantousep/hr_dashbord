<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaryStructure extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function salaryStructures(): HasMany
    {
        return $this->hasMany(SalaryStructureComponent::class);
    }

    public function salaryComponents(): BelongsToMany
    {
        return $this->belongsToMany(SalaryComponent::class, 'salary_structure_components');
    }

    // public function earningsSalaryComponents()
    // {
    //     return $this->salaryComponents()
    // }
}
