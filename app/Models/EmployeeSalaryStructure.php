<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmployeeSalaryStructure extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function employeeSalaryStructures(): HasMany
    {
        return $this->hasMany(EmployeeSalaryStructureComponent::class);
    }
}
