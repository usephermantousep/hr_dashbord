<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class AttendanceGenerator extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'employees' => 'array',
    ];

    public function attendanceStatus(): BelongsTo
    {
        return $this->belongsTo(AttendanceStatus::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_by', 'id');
    }
    public function generateBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generate_by', 'id');
    }

    public function generate(): void
    {
        $from_date = Carbon::parse($this->from_date);
        $to_date = Carbon::parse($this->to_date);
        $dateRange = CarbonPeriod::create($from_date, $to_date);

        // Collect all dates as strings (Y-m-d format)
        $dates = [];
        foreach ($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        // Query for any existing attendance records in the date range for the given employees
        $existingAttendances = Attendance::whereIn('employee_id', $this->employees)
            ->whereIn('date', $dates)
            ->get();

        // If any existing records are found, throw an exception and list them
        if ($existingAttendances->isNotEmpty()) {
            // Format each conflict as "Employee X on Date Y"
            $conflicts = $existingAttendances->map(function ($attendance) {
                return 'Karyawan : ' . Employee::find($attendance->employee_id)->name . ' Tanggal : ' . $attendance->date;
            });

            // Join the conflicts with commas or new lines (your choice)
            $conflictString = implode(', ', $conflicts->toArray());

            // Throw an exception with the formatted string
            throw new \Exception('Attendance records already exist for the following employee(s) and date(s): ' . $conflictString);
        }

        // If no conflicts, prepare data for batch insert
        $data = [];
        foreach ($this->employees as $e) {
            foreach ($dateRange as $date) {
                $data[] = [
                    'employee_id' => $e,
                    'date' => $date->format('Y-m-d'),
                    'attendance_status_id' => $this->attendance_status_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all new attendance records
        if (!empty($data)) {
            Attendance::insert($data);
        }

        $this->is_generated = 1;
        $this->generate_by = Auth::id();
        $this->save();
    }
}
