<?php

namespace App\Filament\Resources\AttendanceStatusResource\Pages;

use App\Filament\Resources\AttendanceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceStatus extends EditRecord
{
    protected static string $resource = AttendanceStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
