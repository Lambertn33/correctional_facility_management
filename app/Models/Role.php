<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    const ROLES = ['SUPER_ADMINISTRATOR','ADMINISTRATOR'];

    const SUPER_ADMINISTRATOR = self::ROLES[0];
    const ADMINISTRATOR = self::ROLES[1];

    protected $fillable = [
        'id','name'
    ];
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * Get all of the users for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
