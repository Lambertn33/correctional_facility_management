<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'appointment_id', 'room_id', 'meeting_ended', 'visitor_token', 'inmate_token'
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
}
