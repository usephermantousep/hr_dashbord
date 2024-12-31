<?php

namespace Database\Seeders;

use App\Models\EmploymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employmentStatuses = [
            'Permanent',
            'Contract',
            'Probation',
            'By Project',
        ];

        foreach ($employmentStatuses as $employmentStatus) {
            EmploymentStatus::create([
                'name' => $employmentStatus,
            ]);
        }
    }
}
