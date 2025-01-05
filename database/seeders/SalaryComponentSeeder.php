<?php

namespace Database\Seeders;

use App\Models\SalaryComponent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaryComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SalaryComponent::insert([
            [
                'name' => 'Gaji Pokok',
                'type' => 1,
            ],
            [
                'name' => 'Tunjangan Jabatan',
                'type' => 1,
            ],
            [
                'name' => 'Tunjangan Keahlian',
                'type' => 1,
            ],
            [
                'name' => 'Tunjangan Transportasi',
                'type' => 1,
            ],
            [
                'name' => 'Tunjangan Makan',
                'type' => 1,
            ],
            [
                'name' => 'Tunjangan Insentif Project',
                'type' => 1,
            ],
            [
                'name' => 'Tunjangan SDA',
                'type' => 1,
            ],
            [
                'name' => 'BPJS Kesehatan',
                'type' => 0,
            ],
            [
                'name' => 'BPJS Ketenagakerjaan',
                'type' => 0,
            ],
            [
                'name' => 'PPh 21',
                'type' => 0,
            ],
            [
                'name' => 'Pinjaman Karyawan',
                'type' => 0,
            ],
            [
                'name' => 'Ijin',
                'type' => 0,
            ],
            [
                'name' => 'Sakit',
                'type' => 0,
            ],
            [
                'name' => 'Terlambat',
                'type' => 0,
            ],
            [
                'name' => 'Alpha',
                'type' => 0,
            ]
        ]);
    }
}
