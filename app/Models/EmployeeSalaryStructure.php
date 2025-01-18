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

    public function employeeSalaryStructure(): HasMany
    {
        return $this->hasMany(EmployeeSalaryStructure::class);
    }

    public function employeeSalaryStructureEarnings(): HasMany
    {
        return $this->hasMany(EmployeeSalaryStructureComponent::class)
            ->whereHas('salaryComponent', function ($query) {
                $query->where('type', 1);
            });
    }

    public function employeeSalaryStructureDeductions(): HasMany
    {
        return $this->hasMany(EmployeeSalaryStructureComponent::class)
            ->whereHas('salaryComponent', function ($query) {
                $query->where('type', 0);
            });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
