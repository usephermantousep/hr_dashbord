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

    public static function getAttendanceId(bool $isRill, ?string $late, ?string $early, ?string $isAbsent)
    {
        if ($isAbsent) {
            return 5;
        }

        if ($isRill && $late) {
            return 2;
        }

        if ($isRill && $early) {
            return 3;
        }

        return 1;
    }
}
