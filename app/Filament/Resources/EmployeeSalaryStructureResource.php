<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeSalaryStructureResource\Pages;
use App\Filament\Resources\EmployeeSalaryStructureResource\RelationManagers;
use App\Models\Employee;
use App\Models\EmployeeSalaryStructure;
use App\Models\SalaryStructureComponent;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeSalaryStructureResource extends Resource
{
    protected static ?string $model = EmployeeSalaryStructure::class;
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-c-queue-list';

    public static function getNavigationParentItem(): ?string
    {
        return __('global.payroll');
    }

    public static function getTitleCaseModelLabel(): string
    {
        return __('global.employee_salary_structure');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.employee_salary_structure');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.employee_salary_structure');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data')
                    ->schema([
                        TextInput::make('document_number')
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                            ->readOnly()
                            ->label(__('global.document_number')),
                        Select::make('employee_id')
                            ->relationship('employee', 'name')
                            ->preload()
                            ->searchable()
                            ->native(false)
                            ->required()
                            ->disabled(fn(Page $livewire) => $livewire instanceof EditRecord)
                            ->label(__('global.employee'))
                            ->afterStateUpdated(function (Set $set, Page $livewire, Get $get) {
                                if (!$get('employee_id')) {
                                    $set('earning', []);
                                }
                                if ($get('employee_id') && $livewire instanceof CreateRecord) {
                                    $employee = Employee::findOrFail($get('employee_id'));
                                    if ($employee->salary_structure_id) {
                                        $salaryEarningComponents = $employee->salaryStructure->salaryEarningComponents;
                                        $salaryDeductionComponents = $employee->salaryStructure->salaryDeductionComponents;
                                        $earningComponents = $salaryEarningComponents->map(function ($i) {
                                            return [
                                                'salary_component_id' => $i->id,
                                                'value' => 0,
                                            ];
                                        })->toArray();
                                        $deductionComponents = $salaryDeductionComponents->map(function ($i) {
                                            return [
                                                'salary_component_id' => $i->id,
                                                'value' => 0,
                                            ];
                                        })->toArray();

                                        $set('earning', $earningComponents);
                                        $set('deduction', $deductionComponents);
                                    }
                                }
                            })
                            ->live()
                            ->required(),

                    ])
                    ->columns(2),

                Section::make()
                    ->schema([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make(__('global.earning'))
                                    ->schema([
                                        Repeater::make('earning')
                                            ->relationship('employeeSalaryStructureEarnings')
                                            ->label('')
                                            ->schema([
                                                Select::make('salary_component_id')
                                                    ->relationship('salaryComponent', 'name', fn(Builder $query) => $query->where('type', 1))
                                                    ->preload()
                                                    ->label(__('global.salary_component'))
                                                    ->searchable()
                                                    ->required()
                                                    ->native(false)
                                                    ->distinct(),
                                                TextInput::make('value')
                                                    ->numeric()
                                                    ->required()
                                                    ->label(__('global.value')),
                                            ])
                                            ->columns(2)
                                            ->hidden(fn(Get $get) => !$get('employee_id'))
                                            ->required(),
                                    ]),
                                Tabs\Tab::make(__('global.deduction'))
                                    ->schema([
                                        Repeater::make('deduction')
                                            ->relationship('employeeSalaryStructureDeductions')
                                            ->label('')
                                            ->schema([
                                                Select::make('salary_component_id')
                                                    ->relationship('salaryComponent', 'name', fn(Builder $query) => $query->where('type', 0))
                                                    ->preload()
                                                    ->label(__('global.salary_component'))
                                                    ->searchable()
                                                    ->required()
                                                    ->native(false)
                                                    ->distinct(),
                                                TextInput::make('value')
                                                    ->numeric()
                                                    ->required()
                                                    ->label(__('global.value')),
                                            ])
                                            ->columns(2)
                                            ->hidden(fn(Get $get) => !$get('employee_id'))
                                            ->required(),
                                    ]),
                            ]),
                    ]),
                Section::make()
                    ->schema([
                        Select::make('created_by')
                            ->relationship('createdBy', 'name')
                            ->label(__('global.created_by')),
                        Select::make('updated_by')
                            ->relationship('updatedBy', 'name')
                            ->label(__('global.updated_by')),
                    ])
                    ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                    ->columns(2)
                    ->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_number')
                    ->label(__('global.document_number')),
                TextColumn::make('employee.name')
                    ->label(__(__('global.employee')))
                    ->searchable(),
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
            'index' => Pages\ListEmployeeSalaryStructures::route('/'),
            'create' => Pages\CreateEmployeeSalaryStructure::route('/create'),
            'view' => Pages\ViewEmployeeSalaryStructure::route('/{record}'),
            'edit' => Pages\EditEmployeeSalaryStructure::route('/{record}/edit'),
        ];
    }
}
