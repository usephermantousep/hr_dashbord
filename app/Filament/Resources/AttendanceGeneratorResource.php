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
use Filament\Forms\Components\Section;
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

    protected static ?string $navigationIcon = 'heroicon-s-arrow-down-on-square-stack';

    public static function getTitleCaseModelLabel(): string
    {
        return __('global.attendance_generator');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.attendance_generator');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.attendance_generator');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Generate Data')
                    ->schema([
                        Fieldset::make()
                            ->schema([
                                TextInput::make('document_number')
                                    ->label(__('global.document_number'))
                                    ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                                    ->disabled(),
                                DatePicker::make('from_date')
                                    ->label(__('global.from_date'))
                                    ->native(false)
                                    ->date('d-M-Y')
                                    ->required(),
                                DatePicker::make('to_date')
                                    ->label(__('global.to_date'))
                                    ->native(false)
                                    ->date('d-M-Y')
                                    ->required(),
                                Select::make('attendance_status_id')
                                    ->relationship('attendanceStatus', 'name')
                                    ->label(__('global.attendance_status'))
                                    ->native(false)
                                    ->required(),
                                Checkbox::make('is_generated')
                                    ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                                    ->label(__('global.is_generated')),
                            ])
                            ->columns(3),
                        Select::make('employees')
                            ->options(
                                Employee::orderBy('name')->get()->pluck('name', 'id')
                            )
                            ->preload()
                            ->multiple()
                            ->searchable()
                            ->columnSpanFull()
                            ->label(__('global.employee')),
                        Fieldset::make()
                            ->schema([
                                Select::make('created_by')
                                    ->relationship('createdBy', 'name')
                                    ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                                    ->label(__('global.created_by')),
                                Select::make('generate_by')
                                    ->relationship('generateBy', 'name')
                                    ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                                    ->label(__('global.generated_by')),
                            ])
                    ])
                    ->disabled(fn(Get $get) => $get('is_generated')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_number')
                    ->label(__('global.document_number'))
                    ->searchable(),
                TextColumn::make('from_date')
                    ->date('d-M-Y'),
                TextColumn::make('to_date')
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
