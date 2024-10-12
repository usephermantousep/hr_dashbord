<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceGeneratorResource\Pages;
use App\Filament\Resources\AttendanceGeneratorResource\RelationManagers;
use App\Models\AttendanceGenerator;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceGeneratorResource extends Resource
{
    protected static ?string $model = AttendanceGenerator::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Generate Data')
                    ->schema([
                        DatePicker::make('from_date')
                            ->label('Dari')
                            ->native(false)
                            ->date('d-M-Y'),
                        DatePicker::make('to_date')
                            ->label('Sampai')
                            ->native(false)
                            ->date('d-M-Y'),
                        Select::make('attendance_status_id')
                            ->relationship('attendanceStatus', 'name')
                            ->label('Attendance Status'),
                        Checkbox::make('is_generated')
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord)),
                        Select::make('employees')
                            ->options(
                                Employee::orderBy('name')->get()->pluck('name', 'id')
                            )
                            ->preload()
                            ->multiple()
                            ->searchable()
                            ->columnSpanFull(),
                        Select::make('created_by')
                            ->relationship('createdBy', 'name')
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord)),
                        Select::make('generate_by')
                            ->relationship('generateBy', 'name')
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord)),
                    ])
                    ->disabled(fn(Get $get) => $get('is_generated')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->date('d-M-Y'),
                IconColumn::make('is_generated')
                    ->boolean(),
                TextColumn::make('createdBy.name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->disabled(
                    fn(AttendanceGenerator $record) => $record->is_generated
                ),
                Tables\Actions\DeleteAction::make()->disabled(
                    fn(AttendanceGenerator $record) => $record->is_generated
                ),
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
            'index' => Pages\ListAttendanceGenerators::route('/'),
            'create' => Pages\CreateAttendanceGenerator::route('/create'),
            'view' => Pages\ViewAttendanceGenerator::route('/{record}'),
            'edit' => Pages\EditAttendanceGenerator::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['createdBy', 'generateBy']);
    }
}
