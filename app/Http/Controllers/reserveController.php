<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Http\Resources\ReserveResource;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    public function index()
    {
        $reserves = Reserve::with('user', 'food')->get();
        return ReserveResource::collection($reserves);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required|string|max:10',
        ]);

        $reserve = Reserve::create($validatedData);
        return new ReserveResource($reserve);
    }

    public function show($id)
    {
        $reserve = Reserve::with('user', 'food')->findOrFail($id);
        return new ReserveResource($reserve);
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
        return new ReserveResource($reserve);
    }

    public function destroy($id)
    {
        $reserve = Reserve::findOrFail($id);
        $reserve->food()->detach();
        $reserve->delete();
        return response()->json(null, 204);
    }
}