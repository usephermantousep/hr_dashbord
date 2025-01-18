<?php

namespace App\Filament\Resources\EmployeeSalaryStructureResource\Pages;

use App\Filament\Resources\EmployeeSalaryStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditEmployeeSalaryStructure extends EditRecord
{
    protected static string $resource = EmployeeSalaryStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user_id = Auth::user()->id;
        $data['updated_by'] = $user_id;
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
