<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Filament\Resources\PayrollResource\RelationManagers;
use App\Helper\DateHelper;
use App\Models\Employee;
use App\Models\Payroll;
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
                            ->afterStateUpdated(
                                function (Get $get, Set $set) {
                                    if (!$get('branch_id')) {
                                        $set('payroll_details', []);
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
                                    });
                                    $set('payroll_details', $employees);
                                }
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
                        Repeater::make('payroll_details')
                            ->schema([
                                Select::make('employee_id')
                                    ->options(Employee::all()->pluck('name', 'id'))
                                    ->label(__('global.employee'))
                                    ->required(),
                            ])
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label(__('global.employee'))
                    ->searchable(),
                TextColumn::make('period')
                    ->date('M-Y')
                    ->label(__('global.period')),
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
