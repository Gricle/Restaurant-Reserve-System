<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;

class ReserveController extends Controller
{
    public function store(Request $request)
    {
        $reserve = new Reserve;
        $reserve->name = $request->name;
        $reserve->phone = $request->phone;
        $reserve->meal_id = $request->meal_id;
        $reserve->save();
    
        return redirect()->route('reserve.index');
    }
    public function index()
{
    $reserves = Reserve::all();
    return view('reserve.index', compact('reserve'));
}

}
