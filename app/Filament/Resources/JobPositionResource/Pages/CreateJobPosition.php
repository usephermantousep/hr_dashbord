<?php

namespace App\Filament\Resources\JobPositionResource\Pages;

use App\Filament\Resources\JobPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobPosition extends CreateRecord
{
    protected static string $resource = JobPositionResource::class;
}
