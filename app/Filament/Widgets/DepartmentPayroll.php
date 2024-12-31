<?php

namespace App\Filament\Widgets;

use App\Helper\DateHelper;
use App\Models\Department;
use App\Models\Payroll;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class DepartmentPayroll extends BaseWidget
{
    protected static ?int $sort = 2;
    public function getTableRecordKey(Model $record): string
    {
        return 'department_name';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payroll::query()
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
                    ->summarize([
                        Sum::make()
                            ->formatStateUsing(fn($state) => "Rp " . number_format($state, 0, ',', '.')),
                    ])
                    ->label('Total Gaji'),


            ])
            ->bulkActions([])
            ->filters([
                Filter::make('filter_date')
                    ->form([
                        Select::make('month')
                            ->options(DateHelper::$months)
                            ->default(now()->subMonth(1)->month),
                        Select::make('year')
                            ->options(DateHelper::$years)
                            ->default(now()->year),
                        Select::make('department')
                            ->multiple()
                            ->options(fn() => Department::all()->pluck('name', 'id'))
                    ])
                    ->indicateUsing(function (array $data) {
                        $res = [];
                        if ($data['month']) {
                            $res[] = Indicator::make('Bulan: ' . DateHelper::$months[$data['month']])
                                ->removeField('region_applicant');
                        }
                        if ($data['year']) {
                            $res[] = Indicator::make('Tahun: ' . DateHelper::$years[$data['year']])
                                ->removeField('placement_applicant');
                        }
                        if ($data['department']) {
                            $departments = Department::whereIn('id', $data['department'])->pluck('name')->toArray();
                            $res[] = Indicator::make('Department: ' . implode(',', $departments));
                        }
                        return $res;
                    })

                    ->query(
                        function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['month'],
                                    fn(Builder $query, $month): Builder => $query->whereMonth('period', $month)
                                )
                                ->when(
                                    $data['year'],
                                    fn(Builder $query, $year): Builder => $query->whereYear('period', $year)
                                )
                                ->when(
                                    $data['department'],
                                    fn(Builder $query, $deptartment): Builder => $query->whereIn('department_id', $deptartment)
                                );
                        }
                    )
            ]);
    }
}
