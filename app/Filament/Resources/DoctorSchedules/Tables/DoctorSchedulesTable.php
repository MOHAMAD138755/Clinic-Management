<?php

namespace App\Filament\Resources\DoctorSchedules\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DoctorSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),

                TextColumn::make('doctor_name')->label('Doctor Name')->searchable(query: function (Builder $query,string $search) {
                    return $query->whereHas('doctor', function (Builder $query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                })->getStateUsing(fn($record) => $record->doctor ? $record->doctor->first_name . ' ' . $record->doctor->last_name : ''),

                TextColumn::make('day_of_week')->label('Day Of Week')->sortable(),

                TextColumn::make('start_time')->label('Start Time')->sortable()
                    ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('H:i') : ''),

                TextColumn::make('end_time')->label('End Time')->sortable()
                    ->formatStateUsing(fn($state) => $state ? Carbon::parse($state)->format('H:i') : ''),

                TextColumn::make('duration')->label('Duration')->sortable(),

                IconColumn::make('is_active')->label('Is Active')->boolean()->sortable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('day_of_week')->label('Day Of Week')->options([
                    '0' => 'saturday',
                    '1' => 'sunday',
                    '2' => 'monday',
                    '3' => 'tuesday',
                    '4' => 'wednesday',
                    '5' => 'thursday',
                    '6' => 'friday',
                ]),

                Filter::make('time')
                    ->label('Select Time')
                    ->form([
                        TimePicker::make('start_time')->seconds(false)->format('H:i'),
                        TimePicker::make('end_time')->seconds(false)->format('H:i'),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['start_time'],
                            fn(Builder $query, $time) => $query->where('start_time', '>=', $time))
                            ->when($data['end_time'],
                                fn(Builder $query, $time) => $query->where('end_time', '<=', $time));
                    })

            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
