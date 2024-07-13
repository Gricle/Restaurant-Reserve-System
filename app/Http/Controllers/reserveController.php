<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Http\Resources\ReserveResource;
use App\Rules\CheckUnpaidReservations;
use App\Rules\BlockUnpaidUserRule;
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
            'user_id' => [
                'required', 
                'exists:users,id', 
                new CheckUnpaidReservations,
                new BlockUnpaidUserRule
            ],
            'date' => 'required|date',
            'time' => 'required|string|max:10',
            'is_payed' => 'required|boolean',
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
        $reserve = Reserve::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => [
                'exists:users,id', 
                new CheckUnpaidReservations,
                new BlockUnpaidUserRule
            ],
            'date' => 'date',
            'time' => 'string|max:10',
            'is_payed' => 'boolean',
        ]);

        $reserve->update($validatedData);

        // If is_payed was updated, apply BlockUnpaidUserRule again
        if (isset($validatedData['is_payed'])) {
            $blockUnpaidUserRule = new BlockUnpaidUserRule();
            $blockUnpaidUserRule->validate('user_id', $reserve->user_id, function($message) {
                // This closure will be called if the user is blocked
                // You can log this message or handle it as needed
            });
        }

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