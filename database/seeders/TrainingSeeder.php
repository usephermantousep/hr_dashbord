<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $letters = range("A", "Z");
        $branches = [];
        $index = 1;
        foreach ($letters as $letter) {
            $branches[] = [
                'name' => 'Training ' . $letter,
                'branch_id' => $index,
                "is_done" => $index % 2
            ];
            $index++;
        }

        Training::insert($branches);
    }
}
