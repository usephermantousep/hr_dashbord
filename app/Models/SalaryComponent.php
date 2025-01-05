<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalaryComponent extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function salaryStructureComponents(): HasMany
    {
        return $this->hasMany(SalaryStructureComponent::class);
    }

    public function salaryStructures(): BelongsToMany
    {
        return $this->belongsToMany(SalaryStructure::class, 'salary_structure_components');
    }
}
