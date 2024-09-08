<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Payroll;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class DepartmentPayroll extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    public function getTableRecordKey(Model $record): string
    {
        return 'department_name';
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payroll::query()
                    ->whereDate('period', '2024-08-01')
                    ->selectRaw('departments.name as department_name, SUM(payrolls.total) as total')
                    ->join('employees', 'employees.id', '=', 'payrolls.employee_id')
                    ->join('departments', 'departments.id', '=', 'employees.department_id')
                    ->groupBy('employees.department_id', 'departments.name')
                    ->orderBy('departments.name', 'asc')
            )
            ->columns([
                TextColumn::make('department_name')
                    ->label('Department'),
                TextColumn::make('total')
                    ->formatStateUsing(fn($state) => "Rp " . number_format($state, 0, ',', '.'))
                    ->label('Total Gaji')
            ])
            ->filters([
                Filter::make('date')
                    ->form([
                        DatePicker::make('date')
                            ->default(now()),
                    ])
            ]);
    }
}
