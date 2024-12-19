<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Training;
use App\Models\TrainingEmployee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class TrainingEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $trainings = Training::all();
        foreach ($trainings as $t) {
            $trainingsEmployees = [];
            $participant = $faker->numberBetween(5, 10);
            $employees = Employee::where('branch_id', $t->branch_id)->take($participant)->get();
            foreach ($employees as $employee) {
                $trainingsEmployees[] = [
                    'training_id' => $t->id,
                    'employee_id' => $employee->id,
                ];
            }
            TrainingEmployee::insert($trainingsEmployees);
        }
    }
}
