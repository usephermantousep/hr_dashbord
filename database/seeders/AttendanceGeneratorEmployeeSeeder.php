<?php

namespace Database\Seeders;

use App\Models\AttendanceGeneratorEmployee;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceGeneratorEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $employees = Employee::where('branch_id', 1)->get();

        // $generatorEmployees = [];

        // foreach ($employees as $e) {
        //     $generatorEmployees[] = [
        //         'employee_id' => $e->id,
        //         'attendance_generator_id' => 1,
        //         'attendance_status_id' => 1,
        //     ];
        // }
        // AttendanceGeneratorEmployee::insert($generatorEmployees);
    }
}
