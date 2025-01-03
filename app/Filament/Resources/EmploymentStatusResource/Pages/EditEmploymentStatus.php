<?php

namespace App\Filament\Resources\EmploymentStatusResource\Pages;

use App\Filament\Resources\EmploymentStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmploymentStatus extends EditRecord
{
    protected static string $resource = EmploymentStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
