<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        return $this->belongsTo(User::class, 'create_by');
    }

    public function generateBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generate_by');
    }

    public function generateds()
    {
        return $this->hasMany(Attendance::class, 'generate_id');
    }

    public function attendanceGeneratorEmployees(): HasMany
    {
        return $this->hasMany(AttendanceGeneratorEmployee::class)
            ->orderBy('date');
    }

    public function attendanceGeneratorIsntEmployees(): HasMany
    {
        return $this->hasMany(AttendanceGeneratorIsntEmployee::class);
    }

    public function generate($generatorId): void
    {
        if ($this->is_generated) {
            throw new \Exception(__('Sudah tergenerate sebelumnya'));
        }
        $attendanceGeneratorEmployee = $this->attendanceGeneratorEmployees;
        $uniqueDates = $attendanceGeneratorEmployee->map(fn($i) => $i->date)->unique();
        $uniqueEmployees = $attendanceGeneratorEmployee->map(fn($i) => $i->employee_id)->unique();
        $minDate = $uniqueDates->min();
        $maxDate = $uniqueDates->max();
        $dateRange = CarbonPeriod::create($minDate, $maxDate);

        $dates = [];
        foreach ($dateRange as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        $existingAttendances = Attendance::whereIn('employee_id', $uniqueEmployees)
            ->whereIn('date', $dates)
            ->limit(10)
            ->get();

        if ($existingAttendances->isNotEmpty()) {
            $conflicts = $existingAttendances->map(function ($attendance) {
                return 'Karyawan : ' . Employee::find($attendance->employee_id)->name . ' Nomer Kehadiran : ' . $attendance->document_number;
            });

            $conflictString = implode(', ', $conflicts->toArray());

            throw new \Exception(__('global.attendance_document_exist', ['datas' => $conflictString]));
        }

        $data = [];
        foreach ($attendanceGeneratorEmployee as $e) {
            $data[] = [
                'employee_id' => $e->employee_id,
                'date' => $e->date,
                'attendance_status_id' => $e->attendance_status_id,
                'created_at' => now(),
                'updated_at' => now(),
                'generate_id' => $this->id,
                'document_number' => DocumentNumber::generateAttendanceDocumentNumber()
            ];
        }

        if (!empty($data)) {
            Attendance::insert($data);
        }

        $this->is_generated = 1;
        $this->generate_by = $generatorId;
        $this->save();
    }
}
