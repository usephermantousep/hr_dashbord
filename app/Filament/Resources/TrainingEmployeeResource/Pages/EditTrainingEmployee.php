<?php

namespace App\Filament\Resources\TrainingEmployeeResource\Pages;

use App\Filament\Resources\TrainingEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingEmployee extends EditRecord
{
    protected static string $resource = TrainingEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
