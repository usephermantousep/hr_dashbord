<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = [
            "Ayah",
            "Ibu",
            "Istri",
            "Suami",
            "Anak",
        ];

        foreach ($families as $family) {
            Family::create([
                'name' => $family,
            ]);
        }
    }
}
