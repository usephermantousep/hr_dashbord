<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobPositionResource\Pages;
use App\Filament\Resources\JobPositionResource\RelationManagers;
use App\Models\JobPosition;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobPositionResource extends Resource
{
    protected static ?string $model = JobPosition::class;

    protected static ?string $navigationIcon = 'heroicon-c-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('global.name')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('global.name'))
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
            'index' => Pages\ListJobPositions::route('/'),
            'create' => Pages\CreateJobPosition::route('/create'),
            'view' => Pages\ViewJobPosition::route('/{record}'),
            'edit' => Pages\EditJobPosition::route('/{record}/edit'),
        ];
    }
}
