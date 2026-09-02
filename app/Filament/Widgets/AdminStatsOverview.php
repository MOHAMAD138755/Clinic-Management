<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialty;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('users', Patient::count())->label('Users')
                ->description('Number of users')
                ->descriptionIcon('heroicon-m-user-group')->color('success')
            ->chart([2,22,10,5,7,20,30,50,5])->url(route('filament.admin.resources.patients.index')),

            Stat::make('doctors', Doctor::where('active',true)->count())->label('Active Doctors')
                ->description('Number of Doctors Active')
                ->descriptionIcon('heroicon-m-user-plus')->color('primary')
                ->chart([2,22,10,5,7,20,30,50,5])->url(route('filament.admin.resources.doctors.index')),

            Stat::make('appointment', Appointment::count())
                ->label('Appointment')
                ->description('Number of Appointments to our weak')
                ->descriptionIcon('heroicon-m-calendar')->color('danger')
                ->chart([2,22,10,5,7,20,30,50,5])->url(route('filament.admin.resources.appointments.index')),

            Stat::make('specialties', Specialty::count())->label('Specialties')
                ->description('Number of Specialties')
                ->descriptionIcon('heroicon-m-academic-cap')->color('warning')
                ->chart([2,22,10,5,7,20,30,50,5])->url(route('filament.admin.resources.specialties.index')),
        ];
    }
}
