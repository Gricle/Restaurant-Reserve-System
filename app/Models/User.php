<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'password',
        'nationalCode',
        'phone',
        'email',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_blocked' => 'boolean',
    ];

    public function reserves(): HasMany
    {
        return $this->hasMany(Reserve::class, 'user_id');
    }
}
