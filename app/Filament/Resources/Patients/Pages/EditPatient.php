<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $patient = $this->record;
        $data['name'] = $patient->user->name;
        $data['email'] = $patient->user->email;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->record->user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        unset(
            $data['name'],
            $data['email'],
            $data['password'],
        );

        return $data;
    }
}
