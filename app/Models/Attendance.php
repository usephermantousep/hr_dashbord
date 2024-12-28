<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function attendanceStatus(): BelongsTo
    {
        return $this->belongsTo(AttendanceStatus::class);
    }

    public function generated(): BelongsTo
    {
        return $this->belongsTo(AttendanceGenerator::class, 'generate_id');
    }
}
