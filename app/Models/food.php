<?php

// app/Models/Food.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Food extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'foods';

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
        'name',
        'type',
        'meal',
    ];

    /**
     * Get the reserves associated with the food item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reserves(): BelongsToMany
    {
        return $this->belongsToMany(Reserve::class, 'reserve_food', 'food_id', 'reserve_id');
    }
}
