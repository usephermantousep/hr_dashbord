<?php

namespace App\Filament\Widgets;

use App\Helper\OptionSelectHelpers;
use App\Helper\ValidationHelper;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class GenderPie extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Gender';
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
        $genders = OptionSelectHelpers::$genders;
        $data = $employees
            ->groupBy('gender')
            ->map->count();
        return [
            'datasets' => [
                [
                    'label' => 'Total',
                    'data' => [
                        $data['Pria'],
                        $data['Wanita'],
                    ],
                    'backgroundColor' => [
                        '#0356fc',
                        '#d6670d',
                    ],
                    'borderColor' => [
                        '#0356fc',
                        '#d6670d',
                    ],
                ],
            ],
            'labels' => collect($genders)->values()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getOptions(): array
    {
        return
            [
                'plugins' => [
                    'datalabels' => [
                        'formatter' => fn($value) => 'asd',
                    ],
                    'legend' => [
                        'display' => true,
                    ],
                ],
                'scales' => [
                    'y' => [
                        'display' => false
                    ],
                    'x' => [
                        'display' => false
                    ]
                ]
            ];
    }
}
