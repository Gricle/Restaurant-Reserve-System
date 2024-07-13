<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'category' => $this->category,
            'meal' => $this->meal,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,

        ];
    }
}