<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prison extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'code', 'province', 'district'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    /**
     * Get the admin associated with the Prison
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'prison_id', 'id');
    }

    /**
     * Get all of the inmates for the Prison
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inmates(): HasMany
    {
        return $this->hasMany(Inmate::class, 'prison_id', 'id');
    }

    /**
     * Get all of the appointments for the Prison
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'prison_id', 'id');
    }
}
