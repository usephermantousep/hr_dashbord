<?php

namespace App\Filament\Resources\AttendanceStatusResource\Pages;

use App\Filament\Resources\AttendanceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAttendanceStatus extends ViewRecord
{
    protected static string $resource = AttendanceStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
