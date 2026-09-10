<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorTimeSlot;
use App\Models\Patient;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')->label('Patient')
                    ->relationship('patient', 'full_name')
                    ->searchable(['full_name', 'phone', 'national_code'])
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->full_name . ' - ' . $record->national_code)
                    ->createOptionForm([
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

                    ])->createOptionUsing(function ($data) {

                        $user = User::create([
                            'name' => $data['full_name'] ?? null,
                            'email' => $data['phone'] . '@patient.local',
                            'password' => Hash::make(Str::random(20)),
                        ]);

                        $patient = Patient::create([
                            'user_id' => $user->id,
                            'phone' => $data['phone'],
                            'address' => $data['address'] ?? null,
                            'birth_date' => $data['birth_date'],
                            'national_code' => $data['national_code'],
                            'full_name' => $data['full_name'],
                        ]);

                        return $patient->id;

                    })
                    ->required(),

                Select::make('doctor_id')->label('Doctor')
                    ->relationship('doctor', 'full_name', fn($query) => $query->with('specialties'))
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        $fullName = $record->first_name . ' ' . $record->last_name;
                        $specialties = $record->specialties->pluck('name')->filter()->implode(' , ');
                        return $specialties ? $fullName . ' - ' . $specialties : $fullName;
                    })
                    ->getSearchResultsUsing(function ($search) {
                        return Doctor::query()
                            ->search($search)
                            ->with('specialties')
                            ->limit(10)
                            ->get()
                            ->mapWithKeys(function ($doctor) {
                                $fullName = $doctor->first_name . ' ' . $doctor->last_name;
                                $specialties = $doctor->specialties->pluck('name')->filter()->implode(' , ');
                                return [
                                    $doctor->id => $specialties ? $fullName . ' - ' . $specialties : $fullName
                                ];
                            })->toArray();
                    })
                    ->searchable()
                    ->required()
                    ->live(),

                Select::make('time_slot_id')->label('Select Appointment')
                    ->placeholder(fn(get $get) => $get('doctor_id') ? 'Select Appointment' : 'Select Doctor')
                    ->searchable()
                    ->options(function (get $get, ?\Illuminate\Database\Eloquent\Model $record) {
                        $doctor_id = $get('doctor_id');

                        if (!$doctor_id) {
                            return [];
                        }
                        $currentSlotId = $record?->time_slot_id;

                        return DoctorTimeSlot::query()
                            ->where('doctor_id', $doctor_id)
                            ->where(function ($query) use ($currentSlotId) {
                                $query->where('is_booked', false)
                                    ->when($currentSlotId, function ($query) use ($currentSlotId) {
                                        $query->Orwhere('id', $currentSlotId);
                                    });
                            })->get()
                            ->mapWithKeys(function ($slot) {
                                return [$slot->id => $slot->start_time . ' - ' . $slot->end_time];
                            })->toArray();

                    })->live()
                    ->required(fn(get $get) => filled($get('doctor_id'))),

            ]);
    }
}
