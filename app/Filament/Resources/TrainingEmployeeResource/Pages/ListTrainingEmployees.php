<?php

namespace App\Filament\Resources\TrainingEmployeeResource\Pages;

use App\Filament\Resources\TrainingEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingEmployees extends ListRecords
{
    protected static string $resource = TrainingEmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
