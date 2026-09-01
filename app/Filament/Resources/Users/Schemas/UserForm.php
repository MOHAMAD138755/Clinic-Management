<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Name')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->unique(ignoreRecord: true),

                TextInput::make('email')->label('Email')
                    ->required()
                    ->email()
                    ->rules(function ($livewire) {
                        $user_id = isset($livewire->record) ? $livewire->record->id : null;
                        return [
                            'required',
                            'email',
                            Rule::unique('users', 'email')->ignore($user_id, 'id'),
                        ];
                    })
                    ->live(onBlur: true),

                TextInput::make('password')->label('Password')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->disabled(fn(string $operation): bool => $operation === 'edit')
                    ->live(onBlur: true)
                    ->rules([
                        Password::min(5)
                            ->max(15)
                            ->mixedCase()
                            ->symbols()
                            ->numbers()
                            ->uncompromised()
                    ]),

                Select::make('roles')->label('Roles')
                    ->multiple()
                    ->required()
                    ->relationship('roles', 'name', fn(Builder $query) => $query->where('name', '!=', 'patient'))
                    ->live(onBlur: true)
                    ->preload()
                    ->searchable(),
            ]);
    }
}
