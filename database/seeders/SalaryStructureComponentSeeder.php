<?php

namespace Database\Seeders;

use App\Models\SalaryComponent;
use App\Models\SalaryStructure;
use App\Models\SalaryStructureComponent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class SalaryStructureComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salaryStructures = SalaryStructure::all();
        $salaryComponents = SalaryComponent::all();
        $faker = Faker\Factory::create('id_ID');
        $data = [];

        foreach ($salaryStructures as $salaryStructure) {
            foreach ($salaryComponents as $salaryComponent) {
                $data[] = [
                    'salary_structure_id' => $salaryStructure->id,
                    'salary_component_id' => $salaryComponent->id
                ];
            }
        }

        SalaryStructureComponent::insert($data);
    }
}
