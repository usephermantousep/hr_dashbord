<?php

namespace Database\Seeders;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class EmployeeSeeder extends Seeder
{
    private static $genders = [
        'Laki-Laki',
        'Perempuan',
    ];
    private static $statuses = [
        'KONTRAK',
        'TETAP',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create('id_ID');

        $employees = [];
        $generates = range(1, 1000);

        foreach ($generates as $_) {
            $fake_branch = $faker->numberBetween(1, 26);
            $fake_department = $faker->numberBetween(1, 26);
            $fake_job_position = $faker->numberBetween(1, 7);
            $fake_index = $faker->numberBetween(0, 1);
            $gender = self::$genders[$fake_index];
            $status = self::$statuses[$fake_index];
            $join_date = $faker->dateTimeBetween('-5 years');
            $leaving_date = Carbon::parse($join_date->getTimestamp())
                ->diffInYears(Carbon::now()) > 3 ? Carbon::now() : null;
            $employees[] = [
                "name" => $faker->unique()->name($gender === 'Perempuan' ? 'female' : 'male'),
                "branch_id" => $fake_branch,
                "department_id" => $fake_department,
                "job_position_id" => $fake_job_position,
                "status" => $status,
                "join_date" => $join_date,
                "gender" => $gender,
                "leaving_date" => $leaving_date,
            ];
        }
        Employee::insert($employees);
    }
}
