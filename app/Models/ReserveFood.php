<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReserveFood extends Model
{
    use HasFactory;

    protected $table = 'reserve_food';

    protected $fillable = [
        'reserve_id',
        'food_id',
    ];

    public function reserve(): BelongsTo
    {
        return $this->belongsTo(Reserve::class);
    }

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}