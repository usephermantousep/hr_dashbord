<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Helper\DateHelper;
use App\Helper\OptionSelectHelpers;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Filament\Resources\Pages\Page as PagesPage;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getTitleCaseModelLabel(): string
    {
        return __('global.employee');
    }

    public static function getPluralLabel(): ?string
    {
        return __('global.employee');
    }

    public static function getNavigationLabel(): string
    {
        return __('global.employee');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data')
                    ->collapsible()
                    ->schema(self::getDataFormSection())->columns(3),
                Section::make(__('global.personal_data'))
                    ->collapsible()
                    ->schema(self::getPersonalDataFormSection())->columns(3),
                Section::make(__('global.insurance'))
                    ->collapsible()
                    ->schema(self::getInsuraceFormSection())->columns(2),
                Section::make(__('global.address'))
                    ->collapsible()
                    ->schema([
                        Repeater::make(__('global.address'))
                            ->relationship('addresses')
                            ->label('')
                            ->schema(self::getAddressFormSection())
                            ->minItems(1)
                            ->maxItems(2)
                            ->columns(3)
                    ]),
                Section::make(__('global.family'))
                    ->collapsible()
                    ->schema([
                        Repeater::make(__('global.family'))
                            ->relationship('families')
                            ->label('')
                            ->schema(self::getFamilyFormSection())
                            ->columns(2)
                    ]),
                Section::make(__('global.contact'))
                    ->collapsible()
                    ->schema([
                        Repeater::make(__('global.contact'))
                            ->relationship('contacts')
                            ->label('')
                            ->schema(self::getContactFormSection())
                            ->columns(3)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee_id')
                    ->label(__('global.employee_id'))
                    ->searchable(),
                TextColumn::make('name')
                    ->label(__('global.name'))
                    ->searchable(),
                TextColumn::make('branch.name')
                    ->label(__('global.branch')),
                TextColumn::make('department.name')
                    ->label(__('global.department')),
                TextColumn::make('jobPosition.name')
                    ->label(__('global.job_position'))
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['branch', 'department', 'jobPosition', 'maritalStatus', 'employmentStatus', 'employmentType', 'addresses', 'families'])
            ->orderBy('name');
    }

    private static function getDataFormSection(): array
    {
        return [
            TextInput::make('employee_id')
                ->label(__('global.employee_id'))
                ->hidden(fn(Page $livewire) => !($livewire instanceof ViewRecord))
                ->disabled(),
            TextInput::make('employee_mechine_id')
                ->label(__('global.employee_mechine_id'))
                ->disabled(),
            TextInput::make('name')
                ->label(__('global.name'))
                ->required(),
            Select::make('branch_id')
                ->relationship('branch', 'name')
                ->native(false)
                ->preload()
                ->searchable()
                ->label(__('global.branch'))
                ->required(),
            Select::make('department_id')
                ->relationship('department', 'name')
                ->native(false)
                ->preload()
                ->searchable()
                ->required()
                ->label(__('global.department')),
            Select::make('job_position_id')
                ->relationship('jobPosition', 'name')
                ->native(false)
                ->preload()
                ->searchable()
                ->required()
                ->label(__('global.job_position')),
            Select::make('employment_status_id')
                ->relationship('employmentStatus', 'name')
                ->preload()
                ->required()
                ->live()
                ->label(__('global.employment_status'))
                ->native(false)
                ->searchable(),
            DatePicker::make('start_contract')
                ->hidden(fn(Get $get) => $get('employment_status_id') == '2')
                ->label(__('global.start_contract'))
                ->native(false)
                ->date('d-M-Y')
                ->nullable(),
            DatePicker::make('end_contract')
                ->hidden(fn(Get $get) => $get('employment_status_id') == '2')
                ->label(__('global.end_contract'))
                ->native(false)
                ->date('d-M-Y')
                ->nullable(),
            Select::make('employment_type_id')
                ->relationship('employmentType', 'name')
                ->preload()
                ->required()
                ->label(__('global.employment_type'))
                ->native(false),
            DatePicker::make('join_date')
                ->label(__('global.join_date'))
                ->native(false)
                ->date('d-M-Y')
                ->required(),
            DatePicker::make('leaving_date')
                ->label(__('global.leaving_date'))
                ->native(false)
                ->date('d-M-Y')
                ->nullable(),
            TextInput::make('years_of_service')
                ->label(__('global.years_of_service'))
                ->readOnly()
                ->hidden(
                    fn(PagesPage $livewire) => !($livewire instanceof ViewRecord)
                )
                ->formatStateUsing(
                    function (Get $get) {
                        $joinDate = $get('join_date');
                        $leavingDate = $get('leaving_date');
                        return DateHelper::calculateYearOfService($joinDate, $leavingDate);
                    }
                ),
            Select::make('salary_structure_id')
                ->relationship('salaryStructure', 'name')
                ->searchable()
                ->preload()
                ->required()
                ->label(__('global.salary_structure')),
        ];
    }

    private static function getPersonalDataFormSection(): array
    {
        return [
            TextInput::make('place_of_birth')
                ->label(__('global.place_of_birth')),
            DatePicker::make('date_of_birth')
                ->label(__('global.date_of_birth'))
                ->native(false)
                ->date('d-M-Y'),
            TextInput::make('age')
                ->label(__('global.age'))
                ->readOnly()
                ->hidden(
                    fn(PagesPage $livewire) => !($livewire instanceof ViewRecord)
                )
                ->formatStateUsing(
                    fn(Get $get) => $get('date_of_birth') ? Carbon::parse(
                        $get('date_of_birth')
                    )->diff(now())->years . ' ' . __('global.years') : ''
                ),
            Select::make('gender')
                ->options(OptionSelectHelpers::$genders)
                ->native(false)
                ->label(__('global.gender'))
                ->required(),
            Select::make('religion')
                ->options(OptionSelectHelpers::$religion)
                ->native(false)
                ->label(__('global.religion'))
                ->required(),
            Select::make('marital_status_id')
                ->relationship('maritalStatus', 'name')
                ->preload()
                ->native(false)
                ->label(__('global.marital_status'))
                ->required(),
            TextInput::make('identity_no')
                ->label(__('global.identity_no')),
            TextInput::make('last_education')
                ->label(__('global.last_education')),
            TextInput::make('last_education_major')
                ->label(__('global.last_education_major')),
            TextInput::make('phone_number')
                ->label(__('global.phone_number')),
            TextInput::make('npwp_no')
                ->label(__('global.npwp_no')),
        ];
    }

    private static function getInsuraceFormSection(): array
    {
        return [
            TextInput::make('health_bpjs')
                ->label(__('global.health_bpjs')),
            TextInput::make('employment_bpjs')
                ->label(__('global.employment_bpjs')),
        ];
    }

    private static function getAddressFormSection(): array
    {
        return [
            Select::make('type')
                ->options(OptionSelectHelpers::$addressType)
                ->native(false)
                ->live()
                ->required(),
            Checkbox::make('is_same_address')
                ->hidden(fn(Get $get) => $get('type') === 'Sesuai KTP')
                ->live()
                ->label(__('global.is_same_address')),
            TextInput::make('address')
                ->hidden(fn(Get $get) => $get('type') !== 'Sesuai KTP' && $get('is_same_address'))
                ->label(__('global.address'))
                ->columnSpanFull(),
        ];
    }

    private static function getFamilyFormSection(): array
    {
        return [
            Select::make('family_id')
                ->relationship('family', 'name', fn(Builder $query) => $query->orderBy('name'))
                ->preload()
                ->native(false)
                ->searchable()
                ->label(__('global.relationship'))
                ->required(),
            TextInput::make('name')
                ->label(__('global.name'))
                ->required(),
            Select::make('gender')
                ->options(OptionSelectHelpers::$genders)
                ->preload()
                ->native(false)
                ->searchable()
                ->label(__('global.gender'))
                ->required(),
            DatePicker::make('birth_date')
                ->label(__('global.date_of_birth'))
                ->native(false)
                ->date('d-M-Y')
        ];
    }

    private static function getContactFormSection(): array
    {
        return [
            Checkbox::make('is_emergency_contact')
                ->label(__('global.is_emergency_contact')),
            TextInput::make('relation')
                ->label(__('global.relationship'))
                ->required(),
            TextInput::make('name')
                ->label(__('global.name'))
                ->required(),
            TextInput::make('phone')
                ->numeric()
                ->label(__('global.phone_number'))
                ->required()

        ];
    }
}
