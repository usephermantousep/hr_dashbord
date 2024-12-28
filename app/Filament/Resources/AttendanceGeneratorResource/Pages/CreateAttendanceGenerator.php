<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\Pages;

use App\Filament\Resources\AttendanceGeneratorResource;
use App\Models\DocumentNumber;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAttendanceGenerator extends CreateRecord
{
    protected static string $resource = AttendanceGeneratorResource::class;
    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['create_by'] = Auth::id();
        $data['document_number'] = DocumentNumber::generateGeneratorDocumentNumber();
        return $data;
    }
}
