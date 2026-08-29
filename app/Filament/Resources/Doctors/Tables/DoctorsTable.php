<?php

namespace App\Filament\Resources\Doctors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('full_name')->label('Full Name')
                    ->getStateUsing(fn($record) => $record->first_name . ' ' . $record->last_name)->sortable()
                    ->searchable(['first_name', 'last_name'])->icon('heroicon-o-user'),
                TextColumn::make('medical_system_number')->label('Medical System Number')->sortable()->searchable()
                ->icon('heroicon-o-identification')->color('primary'),
                TextColumn::make('phone')->label('Phone')->searchable()->icon('heroicon-o-phone')
                ->color('danger'),
                IconColumn::make('active')->boolean()->searchable()->sortable(),
                TextColumn::make('biography')->label('Biography')->sortable()->toggleable(),
                TextColumn::make('specialties.name')->label('Specialties')->sortable()->searchable()->toggleable()
                    ->badge()->color('info'),
            ])
            ->filters([
                SelectFilter::make('specialties')
                ->relationship('specialties', 'name'),
                TernaryFilter::make('active')
                ->label('Active')
                ->trueLabel('Active')
                ->falseLabel('Inactive')
                ->queries(
                    true: fn($query) => $query->where('active', true),
                    false: fn($query) => $query->where('active', false),
                )->placeholder('All Active'),
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
