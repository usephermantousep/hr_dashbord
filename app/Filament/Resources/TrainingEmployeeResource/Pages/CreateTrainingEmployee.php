<?php

namespace App\Filament\Resources\TrainingEmployeeResource\Pages;

use App\Filament\Resources\TrainingEmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrainingEmployee extends CreateRecord
{
    protected static string $resource = TrainingEmployeeResource::class;
    protected static bool $canCreateAnother = false;
}
