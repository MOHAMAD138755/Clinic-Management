<?php

namespace App\Filament\Resources\Reactions;

use App\Filament\Resources\Reactions\Pages\CreateReaction;
use App\Filament\Resources\Reactions\Pages\EditReaction;
use App\Filament\Resources\Reactions\Pages\ListReactions;
use App\Filament\Resources\Reactions\Schemas\ReactionForm;
use App\Filament\Resources\Reactions\Tables\ReactionsTable;
use App\Models\Reaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ReactionResource extends Resource
{
    protected static ?string $model = Reaction::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-s-hand-thumb-up';

    protected static string | UnitEnum | null $navigationGroup = 'Comments And Reactions';

    protected static ?string $recordTitleAttribute = 'reaction management';

    public static function form(Schema $schema): Schema
    {
        return ReactionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReactionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReactions::route('/'),
            'create' => CreateReaction::route('/create'),
            'edit' => EditReaction::route('/{record}/edit'),
        ];
    }
}
