<?php

namespace App\Jobs\Videos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Services\Common\Videos\RoomsService;
use App\Models\Meeting;
use App\Models\Meeting_Token;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Jobs\Admin\AppointmentStatus;

class CreateRoom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $appointment;
    private $inmate;
    private $isAppointmentApproved;

    public $tries = 10;

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
        try {
            DB::beginTransaction();
            $visitorCode = rand(1000, 99999);
            $inmateCode = rand(1000, 9999);
            $createRoom = (new RoomsService)->createMeetingRoom($this->appointment);
            $createdRoomResponse = json_decode($createRoom, TRUE);
            $createdRoomId = $createdRoomResponse['id'];
            $newMeeting = [
                'id' => Str::uuid()->toString(),
                'appointment_id' => $this->appointment->id,
                'room_id' => $createdRoomId,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $newMeetingTokens = [
                'id' => Str::uuid()->toString(),
                'meeting_id' => $newMeeting['id'],
                'visitor_code' => $visitorCode,
                'inmate_code' => $inmateCode,
                'created_at' => now(),
                'updated_at' => now()
            ];

            Meeting::insert($newMeeting);
            Meeting_Token::insert($newMeetingTokens);
            DB::commit();
            dispatch(new AppointmentStatus($this->appointment, $this->inmate, true, $visitorCode));
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->release(20);
            return;
        }
    }
}
