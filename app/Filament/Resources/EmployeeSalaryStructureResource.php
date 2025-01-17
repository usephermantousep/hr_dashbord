<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeSalaryStructureResource\Pages;
use App\Filament\Resources\EmployeeSalaryStructureResource\RelationManagers;
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
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeSalaryStructureResource extends Resource
{
    protected static ?string $model = EmployeeSalaryStructure::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data')
                    ->schema([
                        Select::make('employee_id')
                            ->relationship('employee', 'name')
                            ->preload()
                            ->searchable()
                            ->native(false)
                            ->label(__('global.employee'))
                            // ->afterStateUpdated(fn(Set $set) => $set('asd', 'deded'))
                            ->live()
                            ->required(),
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make(__('global.earning'))
                                    ->schema([
                                        Repeater::make('earning')
                                            ->relationship('employeeSalaryStructures')
                                            ->label('')
                                            ->schema([
                                                Select::make('salary_component_id')
                                                    ->relationship('salaryComponent', 'name', fn(Builder $query) => $query->where('type', 1))
                                                    ->preload()
                                                    ->searchable()
                                                    ->native(false)
                                                    ->distinct(),
                                                TextInput::make('value')
                                                    ->numeric()
                                                    ->label(__('global.value')),
                                            ])
                                            ->columns(2)
                                            ->required(),
                                    ]),
                                Tabs\Tab::make(__('global.deduction'))
                                    ->schema([]),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
