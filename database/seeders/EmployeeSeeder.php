<?php

namespace Database\Seeders;

use App\Helper\OptionSelectHelpers;
use App\Models\DocumentNumber;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create('id_ID');

        $employees = [];
        $generates = range(1, 50);

        foreach ($generates as $_) {
            $fake_branch = $faker->numberBetween(1, 26);
            $fake_department = $faker->numberBetween(1, 26);
            $fake_job_position = $faker->numberBetween(1, 7);
            $genders = ['Pria', 'Wanita'];
            $fake_index = $faker->numberBetween(0, 1);
            $gender = $genders[$fake_index];
            $join_date = $faker->dateTimeBetween('-5 years');
            $leaving_date = Carbon::parse($join_date->getTimestamp())
                ->diffInYears(Carbon::now()) > 3 ? Carbon::now()->subMonth($faker->numberBetween(1, 6)) : null;
            $employees[] = [
                "employee_id" => DocumentNumber::generateEmployeeDocumentNumber($join_date),
                "name" => $faker->unique()->name($gender === 'Wanita' ? 'female' : 'male'),
                "branch_id" => $fake_branch,
                "department_id" => $fake_department,
                "job_position_id" => $fake_job_position,
                "join_date" => $join_date,
                "gender" => $gender,
                "leaving_date" => $leaving_date,
                "employment_status_id" => $leaving_date ? 2 : 1,
                "employment_type_id" => $leaving_date ? $faker->numberBetween(2, 4) : 1,
                'marital_status_id' => $faker->numberBetween(1, 6),
                "religion" => collect(OptionSelectHelpers::$religion)
                    ->keys()
                    ->toArray()[$faker->numberBetween(0, 5)],
                "place_of_birth" => $faker->city(),
                "date_of_birth" => Carbon::parse($join_date->getTimestamp())->subYear($faker->numberBetween(18, 40)),
                "last_education" => $faker->word(),
                "last_education_major" => $faker->word(),
                "identity_no" => $faker->nik(),
                "npwp_no" => $faker->numberBetween(1000000000000, 9999999999999),
                "health_bpjs" => $faker->numberBetween(1000000000000, 9999999999999),
                "employment_bpjs" => $faker->numberBetween(1000000000000, 9999999999999),
                "phone_number" => $faker->phoneNumber('08#########'),
            ];
        }
        Employee::insert($employees);
    }
}
