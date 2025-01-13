<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\Pages;

use App\Filament\Resources\AttendanceGeneratorResource;
use App\Imports\GeneratorAttendanceImport;
use App\Models\DocumentNumber;
use App\Models\Employee;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAttendanceGenerator extends CreateRecord
{
    protected static string $resource = AttendanceGeneratorResource::class;
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $employees = Employee::orderBy('name')->get()->pluck('id', 'employee_mechine_id');
        $data['create_by'] = Auth::id();
        $dataEmployees = (new GeneratorAttendanceImport)->toCollection(storage_path('/app/public/' . $data['file']));
        $employeeAttendances = [];
        foreach ($dataEmployees[0] as $emp) {
            $employeeAttendances[] = [
                'employee_id' => $employees[$emp['emp_no']]
            ];
        }
        $data['employeeAttendances'] = $employeeAttendances;
        $data['document_number'] = DocumentNumber::generateGeneratorDocumentNumber();
        return $data;
    }
}
