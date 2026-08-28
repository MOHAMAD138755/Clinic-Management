<?php

namespace App\Filament\Resources\Specialties\Pages;

use App\Filament\Resources\Specialties\SpecialtiesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSpecialties extends ListRecords
{
    protected static string $resource = SpecialtiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
