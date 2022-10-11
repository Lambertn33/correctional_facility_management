<?php

namespace App\Listeners;

use App\Http\Services\Common\Payment\RequestPayment;
use App\Jobs\Visitor\AppointmentReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;

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
        // FIRST PAY THEN SAVE
        $appointment = $event->appointment;
        $inmate = $event->inmate;
        $telephone = $appointment['telephone'];
        $amount = $event->tariff->amount;
        $payment = (new RequestPayment)->requestPayment($telephone, $amount);
        Appointment::insert($event->appointment);
        dispatch(new AppointmentReceived($appointment, $inmate));
    }
}
