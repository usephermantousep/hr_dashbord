<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            BranchSeeder::class,
            DepartmentSeeder::class,
            JobPositionSeeder::class,
            VacantSeeder::class,
            EmploymentStatusSeeder::class,
            EmployeeSeeder::class,
            AttendanceStatusSeeder::class,
            AttendanceSeeder::class,
            // PayrollSeeder::class,
            TrainingSeeder::class,
            TrainingEmployeeSeeder::class,
            AttendanceGeneratorSeeder::class,
            AttendanceGeneratorEmployeeSeeder::class,
        ]);
    }
}
