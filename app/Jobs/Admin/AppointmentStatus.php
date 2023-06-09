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
    private $rejectionMessage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointment, $inmate, $isAppointmentApproved, $code, $rejectionMessage)
    {
        $this->appointment = $appointment;
        $this->inmate = $inmate;
        $this->isAppointmentApproved = $isAppointmentApproved;
        $this->code = $code;
        $this->rejectionMessage = $rejectionMessage;
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
        $rejectionMessage = $this->rejectionMessage;
        $from = date('h:i:s', strtotime($this->appointment->from));
        $to = date('h:i:s', strtotime($this->appointment->to));
        $appointmentDate = $this->appointment->date;

        $message = $this->isAppointmentApproved
                   ? 'Dear '.$names.' Your request to e-meet '. $inmateNames .' on ' .$appointmentDate. ' from '. $from .' to '. $to .' has been approved.. you will use '. $code .' as your meeting code'
                   : $rejectionMessage;

        (new SendMessage)->sendMessage($telephone, $message);
    }
}
