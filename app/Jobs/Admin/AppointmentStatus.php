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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointment, $inmate, $isAppointmentApproved)
    {
        $this->appointment = $appointment;
        $this->inmate = $inmate;
        $this->isAppointmentApproved = $isAppointmentApproved;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $telephone = $this->appointment->telephone;
        $names = $this->appointment->names;
        $inmateNames = $this->inmate->names;
        $message = $this->isAppointmentApproved
                   ? 'Dear '.$names.' Your request to e-meet '. $inmateNames .' has been approved.. please proceed the payment'
                   : 'Dear '.$names.' Your request to e-meet '. $inmateNames .' has been rejected... request next time';

        (new SendMessage)->sendMessage($telephone, $message);
    }
}
