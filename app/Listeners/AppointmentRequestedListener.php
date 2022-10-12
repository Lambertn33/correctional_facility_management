<?php

namespace App\Listeners;

use App\Http\Services\Common\Payment\RequestPayment;
use App\Jobs\Payment\MakePayment;
use App\Jobs\Visitor\AppointmentReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Appointment;
use App\Models\Payment;

class AppointmentRequestedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $tries = 5;


    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $appointment = $event->appointment;
        $inmate = $event->inmate;
        $payment = $event->payment;
        Payment::insert($payment);
        Appointment::insert($event->appointment);
        dispatch(new AppointmentReceived($appointment, $inmate));
    }
}
