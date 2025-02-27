<?php

namespace App\Filament\Widgets;

use App\Models\Employee;
use App\Models\Training;
use App\Models\Vacant;
use Carbon\Carbon;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget as BaseWidget;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget\Stat;

class CustomStatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $employee = Employee::all('id', 'department_id', 'status', 'join_date', 'leaving_date', 'gender');
        $employee_count = $employee->count();
        $permantent_employee_count = $employee->where('status', 'TETAP')
            ->where('leaving_date', '!=', null)
            ->count();
        $contract_employee_count = $employee->where('status', 'KONTRAK')
            ->where('leaving_date', '!=', null)
            ->count();
        $man_employee = $employee->where('gender', 'Pria')
            ->where('leaving_date', '!=', null)
            ->count();
        $women_employee = $employee->where('gender', 'Wanita')
            ->where('leaving_date', '!=', null)
            ->count();
        $new_employee = $employee->filter(function ($e) {
            return Carbon::parse($e->join_date)->diffInYears(Carbon::now()) < 3 && !($e->leaving_date);
        })->count();
        $vacant_sum = Vacant::all('allocated_amount')->sum('allocated_amount');
        $resign_employee = $employee->where('leaving_date', '!=', null)->count();
        $trainings = Training::all('id', 'is_done');
        $training_counts = $trainings->count();
        $done_trainings = $trainings->where('is_done', true)->count();
        return [
            Stat::make('Total ' . __('global.employee'), (string) $employee_count)
                ->icon('heroicon-o-user')
                ->iconColor('success'),
            Stat::make('Karyawan Tetap', (string) $permantent_employee_count)
                ->icon('heroicon-o-user')
                ->iconColor('warning'),
            Stat::make('Karyawan Kontrak', (string) $contract_employee_count)
                ->icon('heroicon-o-user')
                ->iconColor('danger'),
            Stat::make('Karyawan Pria', (string) $man_employee)
                ->icon('heroicon-o-user')
                ->iconColor('success'),
            Stat::make('Karyawan Wanita', (string) $women_employee)
                ->icon('heroicon-o-user')
                ->iconColor('primary'),
            Stat::make('Karyawan Baru', (string) $new_employee)
                ->icon('heroicon-o-user')
                ->iconColor('primary'),
            Stat::make('Karyawan Resign', (string) $resign_employee)
                ->icon('heroicon-o-user')
                ->iconColor('danger'),
            Stat::make('Karyawan Vacant', (string) $vacant_sum)
                ->icon('heroicon-o-user')
                ->iconColor('success'),
            Stat::make('Jumlah Kebutuhan Training', (string) $training_counts)
                ->icon('heroicon-o-user')
                ->iconColor('danger'),
            Stat::make('Jumlah Pelaksanaan Training', (string) $done_trainings)
                ->icon('heroicon-o-user')
                ->iconColor('success'),
        ];
    }
}
