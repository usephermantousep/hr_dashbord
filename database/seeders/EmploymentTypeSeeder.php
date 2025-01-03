<?php

namespace Database\Seeders;

use App\Models\EmploymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employmentTypes = [
            'Permanent',
            'Contract',
            'Probation',
            'By Project',
        ];

        foreach ($employmentTypes as $employmentType) {
            EmploymentType::create([
                'name' => $employmentType,
            ]);
        }
    }
}
