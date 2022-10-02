<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;
    const STATUS = ['APPROVED','PENDING','REJECTED'];
    const APPROVED = self::STATUS[0];
    const PENDING = self::STATUS[1];
    const REJECTED = self::STATUS[2];
    
    protected $fillable = [
        'id', 'names','telephone', 'national_id','status', 'inmate_id','prison_id', 'tariff_id', 'date', 'from', 'to'
    ];
    
    protected $casts = [
        'id' => 'string',
        'inmate_id' => 'string',
        'tariff_id' => 'string',
        'prison_id' => 'string'
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

    /**
     * Get the prison that owns the Appointment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prison(): BelongsTo
    {
        return $this->belongsTo(Prison::class, 'prison_id', 'id');
    }
}
