<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;

class AppointmentChart extends ChartWidget
{
    protected ?string $heading = 'Appointment Chart';

    protected function getData(): array
    {
        $appointments = Appointment::query()->selectRaw('MONTH(appointment_date) as month , COUNT(*) as total')
            ->whereYear('appointment_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Appointments Count',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $appointments->pluck('total')->toArray(),
                    'fill' => true,
                    'tension' => .4,
                    'pointRadius' => 4,
                ],
            ],'labels' => $appointments->pluck('month')->map(function ($month){
                return date('F', mktime(0, 0, 0, $month, 1));
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
