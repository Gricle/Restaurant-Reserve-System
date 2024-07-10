<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'type',
        'meal',
    ];

    public function reserves(): BelongsToMany
    {
        return $this->belongsToMany(Reserve::class, 'reserve_food', 'food_id', 'reserve_id');
    }
}
