<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReserveResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'time' => $this->time,
            'is_payed' =>$this->is_payed,
            'user' => new UserResource($this->whenLoaded('user')),
            'food' => FoodResource::collection($this->whenLoaded('food')),

            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}