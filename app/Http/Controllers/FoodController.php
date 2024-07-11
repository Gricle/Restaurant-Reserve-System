<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        return response()->json($foods);
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
        return response()->json($food, 201);
    }

    public function show($id)
    {
        $food = Food::findOrFail($id);
        return response()->json($food);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description ' =>'string|max:255',
            'price' => 'string|max:10',
            'image' => 'string|max:255',
            'category' => 'string|max:255',
            'meal' => 'string|max:255',
        ]);

        $food = Food::findOrFail($id);
        $food->update($validatedData);
        return response()->json($food);
    }

    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();
        return response()->json(null, 204);
    }
}
