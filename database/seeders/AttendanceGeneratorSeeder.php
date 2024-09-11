<?php

namespace Database\Seeders;

use App\Models\AttendanceGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceGeneratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttendanceGenerator::insert([
            'date' => now(),
            'generate_by' => 1,
            'create_by' => 1,
        ]);
    }
}
