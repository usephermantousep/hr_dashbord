<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Helper\OptionSelectHelpers;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Filament\Resources\Pages\Page as PagesPage;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getTitleCaseModelLabel(): string
    {
        return __('global.employee');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.employee');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.employee');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data')
                    ->schema([
                        TextInput::make('employee_id')
                            ->label(__('global.employee_id'))
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                            ->disabled(),
                        TextInput::make('name')
                            ->label(__('global.name'))
                            ->required(),
                        Select::make('branch_id')
                            ->relationship('branch', 'name')
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->label(__('global.branch'))
                            ->required(),
                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->label(__('global.department')),
                        Select::make('job_position_id')
                            ->relationship('jobPosition', 'name')
                            ->native(false)
                            ->preload()
                            ->searchable()
                            ->required()
                            ->label(__('global.job_position')),
                        Select::make('status_id')
                            ->relationship('employmentStatus', 'name')
                            ->preload()
                            ->required()
                            ->live()
                            ->label(__('global.employment_status'))
                            ->native(false)
                            ->searchable(),
                        Select::make('religion')
                            ->options(OptionSelectHelpers::$religion)
                            ->label(__('global.religion'))
                            ->required(),
                        Select::make('gender')
                            ->options(OptionSelectHelpers::$genders)
                            ->label(__('global.gender'))
                            ->required(),
                        DatePicker::make('join_date')
                            ->label(__('global.join_date'))
                            ->native(false)
                            ->date('d-M-Y')
                            ->required(),
                        DatePicker::make('leaving_date')
                            ->label(__('global.leaving_date'))
                            ->native(false)
                            ->reactive()
                            ->live()
                            ->date('d-M-Y')
                            ->nullable(),
                        TextInput::make('years_of_service')
                            ->label(__('global.years_of_service'))
                            ->readOnly()
                            ->hidden(
                                fn(PagesPage $livewire) => !($livewire instanceof ViewRecord)
                            )
                            ->live()
                            ->formatStateUsing(
                                function (Get $get) {
                                    $joinDate = $get('join_date');
                                    if (!$joinDate) {
                                        return '';
                                    }
                                    $joinDate = Carbon::parse($joinDate);
                                    $now = now();
                                    if ($get('leaving_date')) {
                                        $now = Carbon::parse($get('leaving_date'));
                                    }
                                    $diff = $joinDate->diff($now);
                                    $years = $diff->y;
                                    $months = $diff->m;

                                    return "{$years} " . __('global.years') . " {$months} " . __('global.months');
                                }
                            )
                            ->reactive()
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_id')
                    ->label(__('global.employee_id'))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('global.name'))
                    ->searchable(),
                TextColumn::make('branch.name')
                    ->label(__('global.branch')),
                TextColumn::make('department.name')
                    ->label(__('global.department')),
                TextColumn::make('jobPosition.name')
                    ->label(__('global.job_position'))
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
