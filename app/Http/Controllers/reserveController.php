<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    public function index()
    {
        $reserves = Reserve::with('user', 'food')->get();
        return response()->json($reserves);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required|string|max:10',
        ]);

        $reserve = Reserve::create($validatedData);
        return response()->json($reserve, 201);
    }

    public function show($id)
    {
        $reserve = Reserve::with('user', 'food')->findOrFail($id);
        return response()->json($reserve);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'exists:users,id',
            'date' => 'date',
            'time' => 'string|max:10',
        ]);

        $reserve = Reserve::findOrFail($id);
        $reserve->update($validatedData);
        return response()->json($reserve);
    }

    public function destroy($id)
    {
        $reserve = Reserve::findOrFail($id);
        $reserve->food()->detach();
        $reserve->delete();
        return response()->json(null, 204);
    }
}
