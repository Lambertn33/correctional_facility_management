<?php

namespace App\Jobs\Visitor;

use App\Http\Services\Common\SendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AppointmentReceived implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $appointment;
    private $inmate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointment, $inmate)
    {
        $this->appointment = $appointment;
        $this->inmate = $inmate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $telephone = $this->appointment['telephone'];
        $names = $this->appointment['names'];
        $inmateNames = $this->inmate->names;
        $inmateNationalId = $this->inmate->national_id;
        $prison = $this->inmate->prison->name;
        $message = 'Dear '.$names.' Your appointment request to e-meet '. $inmateNames .' with an ID 
        '. $inmateNationalId .' located in ' . $prison . ' has been received... we will get back to you soon';

        (new SendMessage)->sendMessage($telephone, $message);
    }
}
