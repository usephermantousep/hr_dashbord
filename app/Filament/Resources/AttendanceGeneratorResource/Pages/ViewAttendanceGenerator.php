<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\Pages;

use App\Filament\Resources\AttendanceGeneratorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAttendanceGenerator extends ViewRecord
{
    protected static string $resource = AttendanceGeneratorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
