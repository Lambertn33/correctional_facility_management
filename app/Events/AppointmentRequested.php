<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppointmentRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment;
    public $inmate;
    public $tariff;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($appointment, $inmate, $tariff)
    {
        $this->appointment = $appointment;
        $this->inmate = $inmate;
        $this->tariff = $tariff;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
