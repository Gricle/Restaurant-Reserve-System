<?php
// app/Models/Reserve.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reserve extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reserves';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'userid',
        'foodid',
    ];

    /**
     * Get the user that owns the reserve.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the food items associated with the reserve.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function food(): BelongsToMany
    {
        return $this->belongsToMany(Food::class, 'reserve_food', 'reserve_id', 'food_id');
    }
}
