<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\DocumentNumber;
use App\Models\Employee;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dates = new DatePeriod(
            new DateTime('2024-11-01'),
            new DateInterval('P1D'),
            new DateTime('2024-11-30')
        );

        $employees = Employee::all()->pluck('id');

        foreach ($dates as $date) {
            $attendances = [];
            foreach ($employees as $employee) {
                $attendances[] = [
                    'employee_id' => $employee,
                    'attendance_status_id' => 1,
                    'date' => $date,
                    'document_number' => DocumentNumber::generateAttendanceDocumentNumber(),
                ];
            }
            Attendance::insert($attendances);
        }
    }
}
