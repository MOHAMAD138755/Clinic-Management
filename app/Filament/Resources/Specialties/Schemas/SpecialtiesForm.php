<?php

namespace App\Filament\Resources\Specialties\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SpecialtiesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->live(onBlur: true)
                    ->debounce()
                    ->validationMessages(['unique' => 'Specialty name already exists.'])
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                ->required()
                ->unique(table: 'specialties', column: 'slug', ignoreRecord: true)
                ->readOnly()
            ]);
    }
}
