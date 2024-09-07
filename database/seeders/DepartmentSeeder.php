<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $letters = range("A", "Z");
        $branches = [];

        foreach ($letters as $letter) {
            $branches[] = ['name' => 'Department ' . $letter];
        }

        Department::insert($branches);
    }
}
