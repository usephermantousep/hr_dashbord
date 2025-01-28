<?php

namespace App\Filament\Resources\PayrollResource\Pages;

use App\Filament\Resources\PayrollResource;
use App\Models\Employee;
use App\Models\EmployeeSalaryStructure;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayroll extends EditRecord
{
    protected static string $resource = PayrollResource::class;

    public array $employeeSalaryStructures = [];
    public array $employees = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();
        $employees = $this->record->payrollEmployees->map(fn($i) => $i->employee_id)->toArray();
        $this->employees = Employee::whereIn('id', $employees)->pluck('name', 'id')->toArray();
        $this->fillEmployeeSalaryStructures($employees);

        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    private function fillEmployeeSalaryStructures(array $employees): void
    {
        $employeeSalaryStructures = EmployeeSalaryStructure::whereIn('employee_id', $employees)->get();

        $employeeSalaryStructures = $employeeSalaryStructures->groupBy('employee_id')->map(function ($items) {
            return $items->mapWithKeys(function ($item) {
                return [$item->id => $item->document_number];
            });
        })->toArray();
        $this->employeeSalaryStructures = [];
        $this->employeeSalaryStructures = $employeeSalaryStructures;
    }
}
