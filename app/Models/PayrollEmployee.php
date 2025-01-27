<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayrollEmployee extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(Payroll::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function employeeSalaryStructure(): BelongsTo
    {
        return $this->belongsTo(EmployeeSalaryStructure::class);
    }

    public function payrollEmployeeStructure(): HasMany
    {
        return $this->hasMany(PayrollEmployeeStructure::class);
    }
}
