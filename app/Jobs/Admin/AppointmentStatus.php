<?php

namespace App\Jobs\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Services\Common\SendMessage;

class AppointmentStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $appointment;
    private $inmate;
    private $isAppointmentApproved;
    private $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointment, $inmate, $isAppointmentApproved, $code)
    {
        $this->appointment = $appointment;
        $this->inmate = $inmate;
        $this->isAppointmentApproved = $isAppointmentApproved;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO GENERATE HOUR
        $telephone = $this->appointment->telephone;
        $names = $this->appointment->names;
        $inmateNames = $this->inmate->names;
        $code = $this->code;

        $message = $this->isAppointmentApproved
                   ? 'Dear '.$names.' Your request to e-meet '. $inmateNames .' has been approved.. you will use '. $code .' as your meeting code'
                   : 'Dear '.$names.' Your request to e-meet '. $inmateNames .' has been rejected... you will be refunded your funds and please request next time';

        (new SendMessage)->sendMessage($telephone, $message);
    }
}
