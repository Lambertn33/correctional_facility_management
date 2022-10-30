<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'appointment_id', 'room_id', 'meeting_ended'
    ];

    protected $casts = [
        'id' => 'string',
        'appointment_id' => 'string'
    ];

    /**
     * Get the appointment that owns the Meeting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function meetingCodes()
    {
        return $this->hasOne(Meeting_Token::class,'meeting_id', 'id');
    }

    public function isMeetingHappeningNow() {
        $meetingStart = $this->appointment->from;
        $meetingEnd = $this->appointment->to;
        $meetingStartTime = date('Y-m-d H:i:s', strtotime($meetingStart));
        $meetingEndTime = date('Y-m-d H:i:s', strtotime($meetingEnd));
        $now = now()->format('Y-m-d H:i:s');
        return (($now > $meetingStartTime) && ($now < $meetingEndTime)) ? true : false;
    }

}
