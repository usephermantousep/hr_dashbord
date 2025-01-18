<?php

namespace App\Filament\Resources\EmployeeSalaryStructureResource\Pages;

use App\Filament\Resources\EmployeeSalaryStructureResource;
use App\Models\DocumentNumber;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateEmployeeSalaryStructure extends CreateRecord
{
    protected static string $resource = EmployeeSalaryStructureResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user_id = Auth::user()->id;
        $data['document_number'] = DocumentNumber::generateEmployeeSalaryStructureDocumentNumber();
        $data['created_by'] = $user_id;
        $data['updated_by'] = $user_id;
        return $data;
    }
}
