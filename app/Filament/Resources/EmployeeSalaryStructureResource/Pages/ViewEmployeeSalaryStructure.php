<?php

namespace App\Filament\Resources\EmployeeSalaryStructureResource\Pages;

use App\Filament\Resources\EmployeeSalaryStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployeeSalaryStructure extends ViewRecord
{
    protected static string $resource = EmployeeSalaryStructureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
