<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inmate extends Model
{
    use HasFactory;

    const STATUS = ['ACTIVE', 'INACTIVE'];

    const ACTIVE = self::STATUS[0];
    const INACTIVE = self::STATUS[1];

    protected $fillable = [
        'id', 'names', 'national_id','father_names','mother_names','prison_id', 'in_date', 'inmate_code', 'reason', 'status'
    ];

    protected $casts = [
        'id' => 'string',
        'prison_id' => 'string'
    ];

    /**
     * Get the prison that owns the Inmate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prison(): BelongsTo
    {
        return $this->belongsTo(Prison::class, 'prison_id', 'id');
    }
    
    /**
     * Get all of the appointments for the Inmate
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'inmate_id', 'id');
    }
}
