<?php

namespace App\Filament\Resources\AttendanceGeneratorResource\Pages;

use App\Filament\Resources\AttendanceGeneratorResource;
use Exception;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

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
                            $this->record->generate();
                            redirect(AttendanceGeneratorResource::getUrl('view', ['record' => $this->record]));
                            Notification::make()
                                ->title('Berhasil generate Kehadiran')
                                ->success()
                                ->send();
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
