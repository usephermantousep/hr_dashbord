<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSalaryStructureComponent extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function employeeSalaryStructure(): BelongsTo
    {
        return $this->belongsTo(EmployeeSalaryStructure::class);
    }

    public function salaryComponent(): BelongsTo
    {
        return $this->belongsTo(SalaryComponent::class);
    }
}
