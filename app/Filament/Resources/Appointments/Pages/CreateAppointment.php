<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Models\Appointment;
use App\Models\DoctorTimeSlot;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        DoctorTimeSlot::whereKey($data['time_slot_id'])->update([
            'is_booked' => true,
        ]);
        return $data;
    }
}
