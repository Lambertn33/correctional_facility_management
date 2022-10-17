<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meeting_Token extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'meeting_id', 'visitor_token', 'inmate_token', 'visitor_code', 'inmate_code'
    ];

    protected $casts = [
        'id' => 'string',
        'meeting_id' => 'string'
    ];

    /**
     * Get the Meeting that owns the Meeting_Token
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
