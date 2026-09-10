<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Models\DoctorTimeSlot;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use PhpParser\Comment\Doc;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        $old_slot_id = $this->record->time_slot_id;
        $new_slot_id = $data['time_slot_id'];

        if ($old_slot_id !== $new_slot_id) {

            if($old_slot_id){
                DoctorTimeSlot::where('id', $old_slot_id)->update(['is_booked' => false]);
            }

            if($new_slot_id){
                DoctorTimeSlot::where('id', $new_slot_id)->update(['is_booked' => true]);
            }

        }
        return $data;
    }
}
