<?php

namespace App\Filament\Resources\Specialties\Pages;

use App\Filament\Resources\Specialties\SpecialtiesResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSpecialties extends EditRecord
{
    protected static string $resource = SpecialtiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
