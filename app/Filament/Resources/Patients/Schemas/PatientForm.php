<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('full_name')
                ->required()
                ->maxLength(100),

                TextInput::make('phone')
                ->required()
                ->maxLength(11)
                ->regex('/^09[0-9]{9}$/')
                ->validationMessages(['regex' => 'phone is not a valid phone number'])
                ->tel()
                ->unique(),

                TextInput::make('national_code')
                ->required()
                ->unique(ignoreRecord: true)
                ->length(10)
                ->numeric(),

                TextInput::make('birth_date')
                ->required()
                ->placeholder('1387/6/30')
                ->mask('9999/99/99'),

                Textarea::make('address')
                ->nullable()
                ->maxLength(255),
            ]);
    }
}
