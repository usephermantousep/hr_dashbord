<?php

namespace Database\Seeders;

use App\Helper\OptionSelectHelpers;
use App\Imports\EmployeeImport;
use App\Models\DocumentNumber;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $women = [
            137,
            155,
            135,
        ];
        $employees = (new EmployeeImport)->toCollection(public_path('/employee.xlsx'));
        $data = $employees[0]->map(fn($i) => [
            'name' => $i->get('nama'),
            'kelamin' => in_array($i->get('emp_no'), $women) ? 'Wanita' : 'Pria',
            'employee_id' => $i->get('emp_no'),
        ])->toArray();

        // Make the array unique
        $uniqueData = array_map("unserialize", array_unique(array_map("serialize", $data)));

        $faker = Faker\Factory::create('id_ID');

        $employees = [];
        foreach ($uniqueData as $data) {
            $fake_branch = $faker->numberBetween(1, 26);
            $fake_department = $faker->numberBetween(1, 26);
            $fake_job_position = $faker->numberBetween(1, 7);
            $join_date = $faker->dateTimeBetween('-5 years');
            $employees[] = [
                "employee_id" => DocumentNumber::generateEmployeeDocumentNumber($join_date),
                "name" => $data['name'],
                "gender" => $data['kelamin'],
                "employee_mechine_id" => $data['employee_id'],
                "branch_id" => $fake_branch,
                "department_id" => $fake_department,
                "job_position_id" => $fake_job_position,
                "join_date" => $join_date,
                "employment_status_id" => 2,
                // "employment_type_id" => 1,
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
                "salary_structure_id" => $faker->numberBetween(1, 3)
            ];
        }
        Employee::insert($employees);
    }
}
