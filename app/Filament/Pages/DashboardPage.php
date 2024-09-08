<?php

namespace App\Filament\Pages;

use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget;
use Filament\Pages\Dashboard;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;

class DashboardPage extends Dashboard
{
    public function getWidgetData(): array
    {
        return [
            // AccountWidget::class,
        ];
    }
}
