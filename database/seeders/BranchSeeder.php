<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $letters = range("A", "Z");
        $branches = [];

        foreach ($letters as $letter) {
            $branches[] = ['name' => 'Cabang ' . $letter];
        }

        Branch::insert($branches);
    }
}
