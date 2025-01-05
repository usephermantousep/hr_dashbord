<?php

namespace App\Filament\Resources\EmployeeSalaryStructureResource\Pages;

use App\Filament\Resources\EmployeeSalaryStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

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
}
