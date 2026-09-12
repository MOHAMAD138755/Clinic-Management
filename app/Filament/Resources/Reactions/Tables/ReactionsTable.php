<?php

namespace App\Filament\Resources\Reactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ReactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),

                TextColumn::make('patient.full_name')->label('Patient Name')->sortable()->searchable(),

                TextColumn::make('doctor.last_name')
                    ->getStateUsing(fn($record) => $record->doctor->first_name . ' ' . $record->doctor->last_name)
                    ->label('Doctor Name')->sortable()->searchable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => '')
                    ->icon(fn ($state) => match ($state) {
                        0 => 'heroicon-s-hand-thumb-down',
                        1 => 'heroicon-s-hand-thumb-up',
                        default => '',
                    })
                    ->iconColor(fn ($state) => match ($state) {
                        0 => 'danger',
                        1 => 'success',
                        default => '',
                    })
                    ->sortable(),


            ])
            ->filters([
                TernaryFilter::make('type')
                    ->label('Type')
                    ->trueLabel('Like')
                    ->falseLabel('Dislike')
                    ->queries(
                        true: fn($query) => $query->where('type', 1),
                        false: fn($query) => $query->where('type', 0),
                    )->placeholder('Select a type'),
            ])
            ->recordActions([
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
