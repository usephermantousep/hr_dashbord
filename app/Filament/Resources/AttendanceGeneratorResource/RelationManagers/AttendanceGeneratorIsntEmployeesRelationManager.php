<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceGeneratorIsntEmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendanceGeneratorIsntEmployees';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('global.isnt_employee');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('employee_name')
                    ->label(__('global.employee'))
                    ->searchable(),
                TextColumn::make('date')
                    ->label(__('global.date'))
                    ->date('d-m-Y'),
                TextColumn::make('mechine_id')
                    ->label(__('global.employee_mechine_id')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
