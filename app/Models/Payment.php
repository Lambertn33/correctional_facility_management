<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    const STATUS = ['PENDING', 'FAILED', 'SUCCESSFUL'];
    const PENDING = self::STATUS[0];
    const FAILED = self::STATUS[1];
    const SUCCESSFUL = self::STATUS[2];
    protected $fillable = [
        'id', 'appointment_id', 'status', 'transaction_id','request_transaction_id'
    ];

    protected $casts = [
        'id' => 'string',
        'appointment_id' => 'string',
    ];

    /**
     * Get the tariff that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tariff(): BelongsTo
    {
        return $this->belongsTo(Tariff::class, 'tariff_id', 'id');
    }

    /**
     * Get the appointment that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'tariff_id', 'id');
    }
}
