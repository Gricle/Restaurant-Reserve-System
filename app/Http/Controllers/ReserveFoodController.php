<?php

namespace App\Http\Controllers;

use App\Models\ReserveFood;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReserveFoodController extends Controller
{
    public function index()
    {
        $reserveFoods = ReserveFood::with('reserve', 'food')->get();
        return response()->json($reserveFoods);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reserve_id' => 'required|exists:reserves,id',
            'food_id' => 'required|exists:foods,id',
        ]);

        $reserveFood = ReserveFood::create($validatedData);
        return response()->json($reserveFood, 201);
    }

    public function show($id)
    {
        $reserveFood = ReserveFood::with('reserve', 'food')->findOrFail($id);
        return response()->json($reserveFood);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'reserve_id' => 'exists:reserves,id',
            'food_id' => 'exists:foods,id',
        ]);

        $reserveFood = ReserveFood::findOrFail($id);
        $reserveFood->update($validatedData);
        return response()->json($reserveFood);
    }

    public function destroy($id)
    {
        $reserveFood = ReserveFood::findOrFail($id);
        $reserveFood->delete();
        return response()->json(null, 204);
    }

    // New method added below

    public function generateReservedFoodsPDF(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $reservedFoods = ReserveFood::whereBetween('created_at', [$startDate, $endDate])
            ->with(['reserve', 'food'])
            ->get();

        $pdf = Pdf::loadView('foods.reserved_pdf', [
            'reservedFoods' => $reservedFoods,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        return $pdf->download('reserved_foods_list.pdf');
    }
}