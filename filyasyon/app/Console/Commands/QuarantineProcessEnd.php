<?php

namespace App\Console\Commands;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Console\Command;

class QuarantineProcessEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:quarantina_end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Karantinasi biten hastalari incele';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d');
        Patient::where('quarantine_end_date', '<', $now)->update(
            [
                'patient_status_id' => 7, //Iyilesti
                'healing_date' => $now,
            ]
        );

    }
}

