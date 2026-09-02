<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AppointmentstatusChart extends ChartWidget
{
    protected ?string $heading = 'Appointment Status Chart';

    protected function getData(): array
    {
        $appointments = Appointment::query()
        ->select('status',DB::raw('count(*) as total'))
        ->groupBy('status')
        ->get();

        $statusColors = [
            'reserved' => 'yellow',
            'no show' => 'orange',
            'cancelled' => 'red',
            'completed' => 'green',
        ];

        $data = [];
        $labels = [];
        $backGroundColors = [];

        foreach ($appointments as $appointment) {
            $status = $appointment->status;
            $labels[] = ucfirst($status);
            $data[] = $appointment->total;
            $backGroundColors[] = $statusColors[$status] ?? '#94a3b8';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Appointments Count',
                    'data' => $data,
                    'borderColor' => 'white',
                    'backgroundColor' => $backGroundColors,
                ]
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
