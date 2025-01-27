<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollEmployeeStructure extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function payrollEmployee(): BelongsTo
    {
        return $this->belongsTo(PayrollEmployee::class);
    }

    public function salaryComponent(): BelongsTo
    {
        return $this->belongsTo(SalaryComponent::class);
    }
}
