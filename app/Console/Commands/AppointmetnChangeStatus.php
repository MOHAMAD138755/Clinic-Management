<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class AppointmetnChangeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:appointmetn-change-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status of appointmetn';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Appointment::where('start_time','<',now())
            ->where('status','reserved')
            ->update(['status'=>'completed']);
    }
}
