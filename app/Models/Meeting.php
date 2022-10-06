<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'visitor_national_id', 'visitor_token','inmate_id','inmate_token','room_id','meeting_time','meeting_ended'
    ];

    protected $casts = [
        'id' => 'string',
        'inmate_id' => 'string'
    ];
}
