<?php

namespace App\Filament\Widgets;

use App\Helper\ValidationHelper;
use App\Models\Employee;
use App\Models\EmploymentType;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class HeadcountTotal extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Headcount Total';
    protected static ?string $pollingInterval = null;
    protected static ?string $maxHeight = '170px';
    protected static ?string $minHeight = '170px';

    protected function getData(): array
    {
        if (!ValidationHelper::isDashboardFilterValidation($this->filters)) {
            return [];
        }
        $endOfMonthFilter = Carbon::parse($this->filters['year'] . '-' . $this->filters['month'] . '-01')->endOfMonth()->format('Y-m-d');
        $employees = Employee::whereDate('leaving_date', '>=', $endOfMonthFilter)
            ->orWhereNull('leaving_date')
            ->get();
        $employmentTypes = EmploymentType::all();
        $data = $employees
            ->groupBy('employment_type_id')
            ->mapWithKeys(function ($group, $employmentTypeId) use ($employmentTypes) {
                $employmentType = $employmentTypes->find($employmentTypeId);
                $statusName = $employmentType ? $employmentType->name : 'Unknown';
                return [$statusName => $group->count()];
            })
            ->toArray();
        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => $data,
                    'backgroundColor' => [
                        '#ccad21',
                        '#0356fc',
                        '#d6670d',
                        '#9e9d9d',
                    ],
                    'borderColor' => [
                        '#ccad21',
                        '#0356fc',
                        '#d6670d',
                        '#9e9d9d',
                    ],
                    'barThickness' => 30
                ],
            ],
            'labels' => $employmentTypes->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                // 'datalabels' => [
                //     'anchor' => 'end',
                //     'align' => 'start',
                //     'font' => [
                //         'weight' => 'bold',
                //     ],
                //     'color' =>  '#333',
                // ]
            ],
            // 'scales' => [
            //     'y' => [
            //         'beginAtZero' => true
            //     ]
            // ]
        ];
    }
}
