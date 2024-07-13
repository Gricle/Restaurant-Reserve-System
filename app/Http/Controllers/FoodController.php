<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Http\Resources\FoodResource;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return FoodResource::collection($foods);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|max:999.99',
            'image' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'meal' => 'required|string|max:255',
        ]);

        $food = Food::create($validatedData);
        return new FoodResource($food);
    }

    public function show($id)
    {
        $food = Food::findOrFail($id);
        return new FoodResource($food);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string|max:255',
            'price' => 'numeric|max:999.99',
            'image' => 'string|max:255',
            'category' => 'string|max:255',
            'meal' => 'string|max:255',
        ]);

        $food = Food::findOrFail($id);
        $food->update($validatedData);
        return new FoodResource($food);
    }

    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();
        return response()->json(null, 204);
    }
}