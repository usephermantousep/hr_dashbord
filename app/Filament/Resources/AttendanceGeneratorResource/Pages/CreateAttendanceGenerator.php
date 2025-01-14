<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\Pages;

use App\Filament\Resources\AttendanceGeneratorResource;
use App\Imports\GeneratorAttendanceImport;
use App\Models\AttendanceGeneratorEmployee;
use App\Models\AttendanceGeneratorIsntEmployee;
use App\Models\AttendanceStatus;
use App\Models\DocumentNumber;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAttendanceGenerator extends CreateRecord
{
    protected static string $resource = AttendanceGeneratorResource::class;
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['document_number'] = DocumentNumber::generateGeneratorDocumentNumber();
        $data['create_by'] = Auth::id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $data = $this->getRecord();

        // Retrieve employees with their machine IDs
        $employees = Employee::orderBy('name')->get()->pluck('id', 'employee_mechine_id');

        // Load and parse the uploaded data
        $filePath = storage_path('app/public/' . $data['file']);
        $dataEmployees = (new GeneratorAttendanceImport)->toCollection($filePath);

        // Initialize an array for bulk insertion
        $employeeAttendances = [];
        $isntEmployeeAttendances = [];

        foreach ($dataEmployees[0] as $emp) {
            // Safeguard against missing 'emp_no' or other keys
            if (!isset($emp['emp_no'], $emp['tanggal'])) {
                continue;
            }

            // Check if the employee exists in the list
            $employeeId = $employees[$emp['emp_no']] ?? null;
            $attendanceDate = Carbon::createFromFormat('d/m/Y', $emp['tanggal']);

            if (!$employeeId) {
                $isntEmployeeAttendances[] = [
                    'employee_name' => $emp['nama'],
                    'date' => $attendanceDate,
                    'mechine_id' => $emp['emp_no'],
                    'attendance_generator_id' => $data['id'],
                ];
                continue;
            }

            // Add attendance data to the array
            $employeeAttendances[] = [
                'attendance_generator_id' => $data['id'],
                'employee_id' => $employeeId,
                'attendance_status_id' => AttendanceStatus::getAttendanceId(
                    $emp['riil'] ?? null,
                    $emp['terlambat'] ?? null,
                    $emp['plg_cepat'] ?? null,
                    $emp['absent'] ?? null
                ),
                'date' => $attendanceDate,
            ];
        }

        // Bulk insert attendance records if any exist
        if (!empty($employeeAttendances)) {
            AttendanceGeneratorEmployee::insert($employeeAttendances);
        }

        if (!empty($isntEmployeeAttendances)) {
            AttendanceGeneratorIsntEmployee::insert(
                $isntEmployeeAttendances
            );
        }
    }
}
