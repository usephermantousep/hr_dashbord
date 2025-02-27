<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmploymentTypeResource\Pages;
use App\Filament\Resources\EmploymentTypeResource\RelationManagers;
use App\Models\EmploymentType;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmploymentTypeResource extends Resource
{
    protected static ?string $model = EmploymentType::class;

    protected static ?string $navigationIcon = 'heroicon-s-inbox-stack';
    protected static ?string $navigationGroup = 'Settings';

    public static function getTitleCaseModelLabel(): string
    {
        return __('global.employment_type');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.employment_type');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.employment_type');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('global.name'))
                    ])
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmploymentTypes::route('/'),
            'create' => Pages\CreateEmploymentType::route('/create'),
            'view' => Pages\ViewEmploymentType::route('/{record}'),
            'edit' => Pages\EditEmploymentType::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return false;
    }
}
