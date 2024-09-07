<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    private static $positions = [
        'Project Manager',
        'Site Manager',
        'Structure Engineering',
        'Kepala Administrasi Proyek',
        'Pelaksana',
        'Surveyor',
        'Drafter',
        'Safety, Health, and Environment'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [];
        foreach (self::$positions as $value) {
            $positions[] = ['name' => $value];
        }
        JobPosition::insert($positions);
    }
}
