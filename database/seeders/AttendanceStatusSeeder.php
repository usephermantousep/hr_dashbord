<?php

namespace Database\Seeders;

use App\Models\AttendanceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceStatusSeeder extends Seeder
{
    private static array $statuses = [
        ['name' => 'HADIR'],
        ['name' => 'TERLAMBAR'],
        ['name' => 'CUTI'],
        ['name' => 'SAKIT'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttendanceStatus::insert(self::$statuses);
    }
}
