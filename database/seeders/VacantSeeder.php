<?php

namespace Database\Seeders;

use App\Models\Vacant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class VacantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $range_insert = range(1, 10);

        $vacants = [];

        foreach ($range_insert as $_) {
            $faker_branch = $faker->numberBetween(1, 26);
            $faker_department = $faker->numberBetween(1, 26);
            $faker_amount = $faker->numberBetween(1, 10);
            $vacants[] = [
                'branch_id' => $faker_branch,
                'department_id' => $faker_department,
                'allocated_amount' => $faker_amount,
            ];
        }
        Vacant::insert($vacants);
    }
}
