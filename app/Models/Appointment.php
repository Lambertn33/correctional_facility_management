<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 'names','telephone', 'national_id', 'inmate_id', 'tariff_id', 'date', 'from', 'to'
    ];
    
    protected $casts = [
        'id' => 'string',
        'inmate_id' => 'string',
        'tariff_id' => 'string'
    ];

    /**
     * Get the inmate that owns the appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inmate(): BelongsTo
    {
        return $this->belongsTo(Inmate::class, 'inmate_id', 'id');
    }

    /**
     * Get the tariff that owns the appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class, 'tariff_id', 'id');
    }

    /**
     * Get the payment associated with the appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'appointment_id', 'id');
    }
}
