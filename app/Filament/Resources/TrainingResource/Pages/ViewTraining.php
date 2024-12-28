<?php

namespace App\Filament\Resources\TrainingResource\Pages;

use App\Filament\Resources\TrainingResource;
use App\Models\Employee;
use App\Models\Training;
use App\Models\TrainingEmployee;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewTraining extends ViewRecord
{
    protected static string $resource = TrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('Tambah Karyawan')
                ->icon('heroicon-o-user-plus')
                ->color('success')
                ->form([
                    Select::make('employees')
                        ->options(Employee::where('leaving_date', null)
                            ->whereNotIn('id', $this->record->employees->map(function ($employee) {
                                return $employee->id;
                            }))
                            ->orderBy('name')
                            ->get()
                            ->pluck('name', 'id'))
                        ->preload()
                        ->multiple()
                        ->required()
                        ->label(__('global.employee')),
                ])
                ->action(function (array $data) {
                    $employees = $data['employees'];
                    foreach ($employees as $employee) {
                        TrainingEmployee::insert([
                            'training_id' => $this->record->id,
                            'employee_id' => $employee,
                        ]);
                    }

                    redirect(TrainingResource::getUrl('view', ['record' => $this->record->id]));

                    Notification::make()
                        ->title('berhasil menambah karyawan')
                        ->success()
                        ->send();
                }),
        ];
    }
}
