<?php

namespace App\Filament\Resources\TrainingEmployeeResource\Pages;

use App\Filament\Resources\TrainingEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTrainingEmployee extends ViewRecord
{
    protected static string $resource = TrainingEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
