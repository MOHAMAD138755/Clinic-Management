<?php

namespace App\Filament\Resources\Comments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->searchable()->sortable(),

                TextColumn::make('patient.full_name')->label('Patient Name')->searchable(),

                TextColumn::make('doctor.full_name')->label('Doctor Name')
                    ->getStateUsing(fn($record) => $record->doctor->first_name . ' ' . $record->doctor->last_name)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('parent.comment_body')->label('Parent Comment body')
                    ->limit(40)->placeholder('Main Comment')->toggleable(),

                IconColumn::make('status')->label('Status')->boolean()->sortable(),

                TextColumn::make('comment_body')->label('Text Comment'),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->label('Status')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->queries(
                        true: fn($query) => $query->where('status', 1),
                        false: fn($query) => $query->where('status', 0),
                    )->placeholder('All Status'),
            ])
            ->recordActions([
                DeleteAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
