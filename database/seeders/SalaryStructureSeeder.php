<?php

namespace Database\Seeders;

use App\Models\SalaryStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaryStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SalaryStructure::insert([
            [
                'name' => 'HO Permanent',
            ],
            [
                'name' => 'HO Contract',
            ],
            [
                'name' => 'HO Probation',
            ],
        ]);
    }
}
