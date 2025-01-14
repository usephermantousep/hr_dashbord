<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceGeneratorIsntEmployee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function attendanceGenerator(): BelongsTo
    {
        return $this->belongsTo(AttendanceGenerator::class, 'attendance_generator_id');
    }
}
