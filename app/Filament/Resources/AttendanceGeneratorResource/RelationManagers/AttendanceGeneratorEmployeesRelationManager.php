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

class AttendanceGeneratorEmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendanceGeneratorEmployees';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('global.employee');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label(__('global.employee'))
                    ->searchable(),
                TextColumn::make('date')
                    ->label(__('global.date'))
                    ->date('d-m-Y'),
                TextColumn::make('attendanceStatus.name')
                    ->label(__('global.attendance_status'))
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }
}
