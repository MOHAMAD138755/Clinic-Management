<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctors extends CreateRecord
{
    protected static string $resource = DoctorsResource::class;
}
