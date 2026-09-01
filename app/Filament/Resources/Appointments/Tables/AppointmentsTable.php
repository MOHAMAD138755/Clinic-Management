<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.full_name')->label('Patient')
                    ->icon('heroicon-o-user')
                    ->color('info')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('doctor.last_name')->label('Doctor')
                    ->icon('heroicon-o-identification')
                    ->color('primary')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('start_time')->label('Start Time')
                    ->dateTime()
                    ->icon('heroicon-s-clock')
                    ->sortable(),
                TextColumn::make('end_time')->label('End Time')
                    ->dateTime()
                    ->icon('heroicon-s-clock')
                    ->sortable(),
                TextColumn::make('status')->label('Status')
                    ->badge()->sortable()->searchable()->toggleable()->color(fn($state) => match ($state) {
                        'cancelled' => 'danger',
                        'completed' => 'success',
                        'no_show' => 'info',
                        'reserved' => 'warning',
                    })->icon(fn($state) => match ($state) {
                        'cancelled' => 'heroicon-o-x-circle',
                        'completed' => 'heroicon-o-check-circle',
                        'no_show' => 'heroicon-o-user-minus',
                        'reserved' => 'heroicon-o-calendar-days',
                    }),
            ])
            ->filters([
                SelectFilter::make('doctor')
                    ->relationship('doctor', 'last_name' ,fn(Builder $query) => $query->orderBy('last_name'))
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(),
                Filter::make('date')->label('Date Range')
                    ->form([
                        DatePicker::make('day')
                    ])->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['day'],
                        fn (Builder $query, $date): Builder => $query->whereDate('start_time', $date),
                    )),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make('delete')
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
