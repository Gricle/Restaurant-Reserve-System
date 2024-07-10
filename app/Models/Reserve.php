<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reserve extends Model
{
    use HasFactory;

    protected $table = 'reserves';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'date',
        'time',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function food(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'reserve_food', 'reserve_id', 'food_id');
    }
}
