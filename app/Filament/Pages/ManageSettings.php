<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->
        components([
            Section::make('general')->label('General Settings')->schema([
                TextInput::make('site_name')->label('Site Name')->required(),

                TextInput::make('site_email')->label('Site Email')->email()->required(),

                TextInput::make('site_phone')->label('Site Phone')->length(11)->required(),

                Textarea::make('site_address')->label('Site Address')->required(),

                TextInput::make('site_facebook')->label('Site Facebook')->required(),
            ]),

            Section::make('maintenance')->label('Maintenance Settings')->schema([
                FileUpload::make('maintenance_logo')->label('Set Logo')->image()->maxSize(1024)
                    ->directory('settings'),

                TextInput::make('maintenance_title')->label('Title')->required(),

                Textarea::make('maintenance_description')->label('Description')->required(),
            ]),

        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved successfully.')
            ->success()
            ->send();
    }
}
