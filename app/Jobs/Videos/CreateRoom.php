<?php

namespace App\Jobs\Videos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Services\Common\Videos\RoomsService;
use App\Http\Services\Common\Videos\TokensGenerating;
use App\Models\Meeting;
use Illuminate\Support\Str;

class CreateRoom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $appointment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $createRoom = (new RoomsService)->createMeetingRoom($this->appointment);
        $createdRoomResponse = json_decode($createRoom, TRUE);
        $createdRoomId = $createdRoomResponse['id'];
        Meeting::create([
            'id' => Str::uuid()->toString(),
            'appointment_id' => $this->appointment->id,
            'room_id' => $createdRoomId,
            'visitor_token' => (new TokensGenerating)->generateToken(false),
            'inmate_token' => (new TokensGenerating)->generateToken(false)
        ]);
    }
}
