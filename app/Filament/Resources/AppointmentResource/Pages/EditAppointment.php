<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function  mutateFormDataBeforeFill(array $data): array
    {
        $appointment = $this->record;
        $appointment->load(['patient.user', 'doctor.user']);

        $data['doctor_name'] = $appointment->doctor->user->name ?? null;
        $data['patient_name'] = $appointment->patient->user->name ?? null;

        return $data;
    }
}
