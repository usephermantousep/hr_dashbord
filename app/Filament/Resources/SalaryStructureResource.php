<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryStructureResource\Pages;
use App\Filament\Resources\SalaryStructureResource\RelationManagers;
use App\Filament\Resources\SalaryStructureResource\RelationManagers\SalaryDeductionComponentsRelationManager;
use App\Filament\Resources\SalaryStructureResource\RelationManagers\SalaryEarningComponentsRelationManager;
use App\Helper\OptionSelectHelpers;
use App\Models\SalaryStructure;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalaryStructureResource extends Resource
{
    protected static ?string $model = SalaryStructure::class;
    protected static ?int $navigationSort = 2;

    // protected static ?string $navigationIcon = 'heroicon-c-numbered-list';

    public static function getNavigationParentItem(): ?string
    {
        return __('global.payroll');
    }

    public static function getTitleCaseModelLabel(): string
    {
        return __('global.salary_structure');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.salary_structure');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.salary_structure');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('global.name'))
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('global.name'))
                    ->searchable()

            ])
            ->filters([])
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
            SalaryEarningComponentsRelationManager::class,
            SalaryDeductionComponentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSalaryStructures::route('/'),
            'create' => Pages\CreateSalaryStructure::route('/create'),
            'view' => Pages\ViewSalaryStructure::route('/{record}'),
            'edit' => Pages\EditSalaryStructure::route('/{record}/edit'),
        ];
    }
}
