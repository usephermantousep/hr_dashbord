<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Filament\Resources\PayrollResource\RelationManagers;
use App\Helper\DateHelper;
use App\Models\Employee;
use App\Models\EmployeeSalaryStructure;
use App\Models\Payroll;
use App\Models\SalaryStructure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'heroicon-s-banknotes';


    public static function getTitleCaseModelLabel(): string
    {
        return __('global.payroll');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.payroll');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.payroll');
    }

    private static function afterStateUpdatedBranch(Get $get, Set $set, Component $livewire): void
    {
        if (!$get('branch_id')) {
            $set(__('global.employee'), []);
            return;
        }

        $employees = Employee::where(
            'branch_id',
            $get('branch_id')
        )->orderBy('name')
            ->pluck('id');
        $employees = collect($employees)->map(function ($i) {
            return [
                'employee_id' => $i
            ];
        })->toArray();
        if (empty($employees)) {
            $set(__('global.employee'), []);
            return;
        }
        $employeeSalaryStructures = EmployeeSalaryStructure::whereIn('employee_id', $employees)->get();

        $employeeSalaryStructures = $employeeSalaryStructures->groupBy('employee_id')->map(function ($items) {
            return $items->mapWithKeys(function ($item) {
                return [$item->id => $item->document_number];
            });
        })->toArray();
        $livewire->employeeSalaryStructures = [];
        $livewire->employee = [];
        $livewire->employeeSalaryStructures = $employeeSalaryStructures;
        $livewire->employees = Employee::whereIn('id', $employees)->pluck('name', 'id')->toArray();
        $set(__('global.employee'), []);
        $set(__('global.employee'), $employees);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('branch_id')
                            ->relationship('branch', 'name')
                            ->label(__('global.branch'))
                            ->live()
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(
                                fn(Get $get, Set $set, Component $livewire) => self::afterStateUpdatedBranch($get, $set, $livewire)
                            )
                            ->required(),
                        Select::make('year')
                            ->options(collect(DateHelper::$years)
                                ->filter(fn($i) => $i >= now()->subYear(1)->year))
                            ->label(__('global.year'))
                            ->required(),
                        Select::make('month')
                            ->label(__('global.month'))
                            ->options(DateHelper::$months)
                            ->required(),
                        TextInput::make('total')
                            ->numeric()
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord)),
                    ])
                    ->columns(3),
                Section::make()
                    ->schema([
                        Repeater::make(__('global.employee'))
                            ->grid(2)
                            ->relationship('payrollEmployees')
                            ->itemLabel(
                                fn($state, Component $livewire) => $state ? ucwords($livewire->employees[$state['employee_id']] ?? '')  : ''
                            )
                            ->schema([
                                Select::make('employee_id')
                                    ->options(fn(Component $livewire) => $livewire->employees)
                                    ->label(__('global.employee'))
                                    ->live()
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),
                                Select::make('employee_salary_structure_id')
                                    ->options(
                                        fn(\Livewire\Component $livewire, Get $get) => $get(
                                            'employee_id'
                                        ) ? $livewire->employeeSalaryStructures[$get('employee_id')] ?? [] : []
                                    )
                                    ->label(__('global.employee_salary_structure'))
                                    ->live()
                                    ->preload()
                                    ->required()
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->addable(false)
                            ->distinct()
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.name')
                    ->label(__('global.branch'))
                    ->searchable(),
                TextColumn::make('month')
                    ->state(fn(Payroll $record) => DateHelper::$months[$record->month])
                    ->label(__('global.month')),
                TextColumn::make('year')
                    ->label(__('global.year')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayrolls::route('/'),
            'create' => Pages\CreatePayroll::route('/create'),
            'view' => Pages\ViewPayroll::route('/{record}'),
            'edit' => Pages\EditPayroll::route('/{record}/edit'),
        ];
    }
}
