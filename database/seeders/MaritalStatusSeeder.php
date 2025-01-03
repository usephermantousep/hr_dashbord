<?php

namespace Database\Seeders;

use App\Models\MaritalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maritalStatuses = [
            'Belum Menikah',
            'Menikah Belum Punya Anak',
            'Menikah Anak 1',
            'Menikah Anak 2',
            'Menikah Anak 3',
            'Cerai',
        ];

        foreach ($maritalStatuses as $maritalStatus) {
            MaritalStatus::create([
                'name' => $maritalStatus,
            ]);
        }
    }
}
