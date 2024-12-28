<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-c-calendar-days';

    public static function getTitleCaseModelLabel(): string
    {
        return __('global.attendance');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.attendance');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.attendance');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('document_number')
                            ->label(__('global.document_number'))
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                            ->disabled(),
                        DatePicker::make('date')
                            ->native(false)
                            ->label(__('global.date'))
                            ->disabled(fn(Attendance $attendance) => $attendance->generated)
                            ->required(),
                        Select::make('employee_id')
                            ->relationship('employee', 'name')
                            ->preload()
                            ->searchable()
                            ->native(false)
                            ->label(__('global.employee'))
                            ->disabled(fn(Attendance $attendance) => $attendance->generated)
                            ->required(),
                        Select::make('attendance_status_id')
                            ->relationship('attendanceStatus', 'name')
                            ->label(__('global.attendance_status'))
                            ->disabled(fn(Attendance $attendance) => $attendance->generated)
                            ->required(),
                        Select::make('generated')
                            ->relationship('generated', 'document_number')
                            ->label(__('global.generator_document'))
                            ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                            ->suffixAction(
                                Action::make('redirect')
                                    ->icon('heroicon-o-eye')
                                    ->action(
                                        fn(Attendance $attendance) => $attendance->generated ? redirect(AttendanceGeneratorResource::getUrl(
                                            'view',
                                            ['record' => $attendance->generated->id]
                                        )) : null
                                    )
                            )
                            ->disabled(),
                    ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_number')
                    ->label(__('global.document_number')),
                TextColumn::make('date')
                    ->date('d-M-y')
                    ->label(__('global.date')),
                TextColumn::make('employee.name')
                    ->label(__('global.name')),
                TextColumn::make('attendanceStatus.name')
                    ->label(__('global.attendance_status')),
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'view' => Pages\ViewAttendance::route('/{record}'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['employee', 'attendanceStatus', 'generated'])
            ->orderBy('date', 'desc');
    }
}
