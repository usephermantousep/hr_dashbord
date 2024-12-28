<?php

namespace App\Filament\Resources\AttendanceStatusResource\Pages;

use App\Filament\Resources\AttendanceStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendanceStatus extends CreateRecord
{
    protected static string $resource = AttendanceStatusResource::class;
    protected static bool $canCreateAnother = false;
}
