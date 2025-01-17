<?php

namespace App\Observers;

use App\Models\AttendanceGenerator;
use Illuminate\Support\Facades\Storage;

class AttendanceGeneratorObserver
{
    /**
     * Handle the AttendanceGenerator "created" event.
     */
    public function created(AttendanceGenerator $attendanceGenerator): void
    {
        //
    }

    /**
     * Handle the AttendanceGenerator "updated" event.
     */
    public function updated(AttendanceGenerator $attendanceGenerator): void
    {
        //
    }

    /**
     * Handle the AttendanceGenerator "deleted" event.
     */
    public function deleted(AttendanceGenerator $attendanceGenerator): void
    {
        if (Storage::disk('public')->exists($attendanceGenerator->file)) {
            try {
                Storage::disk('public')->delete($attendanceGenerator->file);
            } catch (\Throwable $e) {
            }
        }
    }

    /**
     * Handle the AttendanceGenerator "restored" event.
     */
    public function restored(AttendanceGenerator $attendanceGenerator): void
    {
        //
    }

    /**
     * Handle the AttendanceGenerator "force deleted" event.
     */
    public function forceDeleted(AttendanceGenerator $attendanceGenerator): void {}
}
