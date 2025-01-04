<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DepartmentPayroll;
use App\Filament\Widgets\GenderPie;
use App\Filament\Widgets\HeadcountTotal;
use App\Helper\DateHelper;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;
use Illuminate\Contracts\View\View;

class DashboardPage extends Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filter')
                    ->schema([
                        Select::make('year')
                            ->label(__('global.year'))
                            ->native(false)
                            ->searchable()
                            ->options(collect(DateHelper::$years)->sortKeysDesc()->toArray())
                            ->default(now()->year),
                        Select::make('month')
                            ->label(__('global.month'))
                            ->options(DateHelper::$months)
                            ->native(false)
                            ->searchable()
                            ->default(now()->month),
                    ])->columns(4)
            ]);
    }
    public function getColumns(): int|string|array

    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }


    public function getWidgets(): array
    {
        return [
            // DepartmentPayroll::class,
            HeadcountTotal::class,
            GenderPie::class,
        ];
    }
}
