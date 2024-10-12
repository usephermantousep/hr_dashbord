<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\Pages;

use App\Filament\Resources\AttendanceGeneratorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAttendanceGenerator extends CreateRecord
{
    protected static string $resource = AttendanceGeneratorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['create_by'] = Auth::id();
        return $data;
    }
}
