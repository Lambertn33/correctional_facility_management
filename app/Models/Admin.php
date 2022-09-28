<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'user_id', 'prison_id', 'has_changed_password', 'password_expiration_days'
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'prison_id' => 'string'
    ];

    /**
     * Get the user that owns the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the prison that owns the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prison(): BelongsTo
    {
        return $this->belongsTo(Prison::class, 'prison_id', 'id');
    }
}
