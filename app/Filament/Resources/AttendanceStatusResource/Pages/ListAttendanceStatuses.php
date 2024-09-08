<?php

namespace App\Filament\Resources\AttendanceStatusResource\Pages;

use App\Filament\Resources\AttendanceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceStatuses extends ListRecords
{
    protected static string $resource = AttendanceStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
