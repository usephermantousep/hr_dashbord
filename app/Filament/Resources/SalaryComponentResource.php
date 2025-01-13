<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryComponentResource\Pages;
use App\Filament\Resources\SalaryComponentResource\RelationManagers;
use App\Helper\OptionSelectHelpers;
use App\Models\SalaryComponent;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
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

class SalaryComponentResource extends Resource
{
    protected static ?string $model = SalaryComponent::class;

    // protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    public static function getNavigationParentItem(): ?string
    {
        return __('global.payroll');
    }

    public static function getTitleCaseModelLabel(): string
    {
        return __('global.salary_component');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.salary_component');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.salary_component');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('data')
                    ->schema([
                        TextInput::make('name')
                            ->label(__('global.name')),
                        Select::make('type')
                            ->label(__('global.type'))
                            ->options(OptionSelectHelpers::$salaryComponentTypes),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('global.name'))
                    ->searchable(),
                TextColumn::make('type')
                    ->formatStateUsing(
                        fn(SalaryComponent $record) => OptionSelectHelpers::$salaryComponentTypes[$record->type]
                    )
                    ->label(__('global.type')),
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
            'index' => Pages\ListSalaryComponents::route('/'),
            'create' => Pages\CreateSalaryComponent::route('/create'),
            'view' => Pages\ViewSalaryComponent::route('/{record}'),
            'edit' => Pages\EditSalaryComponent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->orderBy('name');
    }
}
