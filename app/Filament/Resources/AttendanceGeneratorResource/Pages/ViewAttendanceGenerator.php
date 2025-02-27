<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\Pages;

use App\Filament\Resources\AttendanceGeneratorResource;
use App\Jobs\GenerateAttendanceJob;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ViewAttendanceGenerator extends ViewRecord
{
    protected static string $resource = AttendanceGeneratorResource::class;

    protected function getHeaderActions(): array
    {
        $record = $this->record;
        $actions = [];
        if (!$record->is_generated) {
            $actions = [
                Actions\EditAction::make(),
                Action::make('generate')
                    ->action(function () {
                        try {
                            Notification::make()
                                ->title('Proses generate kehadiran')
                                ->info()
                                ->send();
                            GenerateAttendanceJob::dispatch($this->record->id, Auth::id());
                            redirect(AttendanceGeneratorResource::getUrl('index'));
                        } catch (Exception $e) {
                            Notification::make()
                                ->title($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    })
            ];
        }
        return $actions;
    }
}
