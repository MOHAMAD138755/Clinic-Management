<?php

namespace App\Filament\Resources\Specialties;

use App\Filament\Resources\Specialties\Pages\CreateSpecialties;
use App\Filament\Resources\Specialties\Pages\EditSpecialties;
use App\Filament\Resources\Specialties\Pages\ListSpecialties;
use App\Filament\Resources\Specialties\Schemas\SpecialtiesForm;
use App\Filament\Resources\Specialties\Tables\SpecialtiesTable;
use App\Models\Specialty;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialtiesResource extends Resource
{
    protected static ?string $model = Specialty::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $recordTitleAttribute = 'Specialties Management';

    protected static string|null|\UnitEnum $navigationGroup = 'Doctors And Specialties';

    public static function form(Schema $schema): Schema
    {
        return SpecialtiesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpecialtiesTable::configure($table);
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
            'index' => ListSpecialties::route('/'),
            'create' => CreateSpecialties::route('/create'),
            'edit' => EditSpecialties::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
