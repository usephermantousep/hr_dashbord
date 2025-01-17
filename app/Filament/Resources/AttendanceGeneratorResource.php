<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceGeneratorResource\Pages;
use App\Filament\Resources\AttendanceGeneratorResource\RelationManagers\AttendanceGeneratorEmployeesRelationManager;
use App\Filament\Resources\AttendanceGeneratorResource\RelationManagers\AttendanceGeneratorIsntEmployeesRelationManager;
use App\Models\AttendanceGenerator;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
                                FileUpload::make('file')
                                    ->storeFileNamesIn('file_name'),
                                Checkbox::make('is_generated')
                                    ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                                    ->label(__('global.is_generated')),
                            ])
                            ->columns(3),
                        Fieldset::make()
                            ->schema([
                                Select::make('created_by')
                                    ->relationship('createdBy', 'name')
                                    ->label(__('global.created_by')),
                                Select::make('generate_by')
                                    ->relationship('generateBy', 'name')
                                    ->label(__('global.generated_by')),
                                Textarea::make('error_message')
                                    ->readOnly()
                                    ->hidden(
                                        fn(AttendanceGenerator $record) => $record->is_generated || !$record->error_message
                                    )
                                    ->rows(10)
                                    ->columnSpanFull(),
                            ])
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                            ->columns(2)
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
                IconColumn::make('is_generated')
                    ->label(__('global.is_generated'))
                    ->boolean(),
                TextColumn::make('createdBy.name')
                    ->label(__('global.created_by'))
                    ->searchable(),
                TextColumn::make('generateBy.name')
                    ->label(__('global.generated_by'))
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
            AttendanceGeneratorEmployeesRelationManager::class,
            AttendanceGeneratorIsntEmployeesRelationManager::class,
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
