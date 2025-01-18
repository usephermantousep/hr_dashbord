<?php

namespace App\Filament\Resources\SalaryStructureResource\Pages;

use App\Filament\Resources\SalaryStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSalaryStructure extends CreateRecord
{
    protected static string $resource = SalaryStructureResource::class;
    protected static bool $canCreateAnother = false;
}
