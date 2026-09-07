<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('status')->label('Status')
                ->required()->default(false),
            ]);
    }
}
