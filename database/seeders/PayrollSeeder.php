<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker;

class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $employees = Employee::all()->pluck('id');
        $period = Carbon::now()->subMonth(1)->startOfMonth();
        $payrolls = [];
        foreach ($employees as $employee) {
            $payrolls[] = [
                'employee_id' => $employee,
                'period' => $period,
                'total' => $faker->numberBetween(3000000, 5000000)
            ];
        }
        Payroll::insert($payrolls);
    }
}
