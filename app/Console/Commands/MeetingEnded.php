<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Meeting;

class MeetingEnded extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meeting:ended';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update status of all ended meetings';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $now = now()->format('Y-m-d H:i:s');
            $allMeetings = Meeting::with('appointment')->get();
            if (count($allMeetings) > 0) {
                foreach ($allMeetings as $meeting) {
                    $meetingEnd = $meeting->appointment->to;
                    $meetingEndTime = date('Y-m-d H:i:s', strtotime($meetingEnd));
                    if ($now > $meetingEndTime) {
                        $meeting->update([
                            'meeting_ended' => true
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
