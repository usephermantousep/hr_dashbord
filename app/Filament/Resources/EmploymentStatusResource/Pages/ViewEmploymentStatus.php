<?php

namespace App\Filament\Resources\EmploymentStatusResource\Pages;

use App\Filament\Resources\EmploymentStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEmploymentStatus extends ViewRecord
{
    protected static string $resource = EmploymentStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
