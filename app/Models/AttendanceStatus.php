<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceStatus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
