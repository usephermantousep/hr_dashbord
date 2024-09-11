<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\Pages;

use App\Filament\Resources\AttendanceGeneratorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceGenerators extends ListRecords
{
    protected static string $resource = AttendanceGeneratorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
