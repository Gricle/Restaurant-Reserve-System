<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReserveFoodResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reserve_id' => $this->reserve_id,
            'food_id' => $this->food_id,
            'reserve' => new ReserveResource($this->whenLoaded('reserve')),
            'food' => new FoodResource($this->whenLoaded('food')),
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}