<?php

namespace App\Filament\Resources\Patients\Schemas;

use Closure;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient Information')
                    ->schema([
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
                            ->rules(function () {
                                return function (string $attribute, mixed $value, Closure $fail) {
                                    $trimValue = is_string($value) ? trim($value) : $value;
                                    if (!is_string($trimValue) || !preg_match('/^\d{10}$/', $trimValue)) {
                                        $fail('فرمت کد ملی باید 10 رقم باشد');
                                        return;
                                    }

                                    if (strlen($trimValue) != 10) {
                                        $fail('کد ملی باید 10 رقم باشد');
                                        return;
                                    }

                                    if (!ctype_digit($trimValue)) {
                                        $fail('کد ملی باید شامل ارقام باشد');
                                        return;
                                    }

                                    $nationalId = $trimValue;

                                    $sum = 0;

                                    for ($i = 0; $i < 9; $i++) {
                                        $sum += $nationalId[$i] * (10 - $i);
                                    }

                                    $remainder = $sum % 11;

                                    $controlDigit = (int)$nationalId[9];

                                    $expectedControlDigit = ($remainder < 2) ? $remainder : (11 - $remainder);

                                    if ($controlDigit !== $expectedControlDigit) {
                                        $fail('کد ملی معتبر نیست(رقم کنترلی اشتباه است)');
                                    }
                                };
                            }),

                        TextInput::make('birth_date')
                            ->required()
                            ->placeholder('1387/6/30')
                            ->mask('9999/99/99'),

                        Textarea::make('address')
                            ->nullable()
                            ->maxLength(255),
                    ]),
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')->label('User Name')
                            ->required()
                            ->maxLength(60)
                            ->live(onBlur: true),


                        TextInput::make('email')->label('User Email')
                            ->required()
                            ->email()
                            ->rules(function ($livewire) {
                                $user_id = isset($livewire->record) ? $livewire->record->id : null;
                                return [
                                    'required',
                                    'email',
                                    Rule::unique('users', 'email')->ignore($user_id,'id'),
                                ];
                            })
                            ->live(onBlur: true),

                        TextInput::make('password')->label('User Password')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->live(onBlur: true)
                            ->rules([
                                Password::min(5)
                                    ->max(15)
                                    ->mixedCase()
                                    ->symbols()
                                    ->numbers()
                                    ->uncompromised()
                            ])
                    ])
            ]);
    }
}
