<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'nationalCode' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'is_blocked' => 'boolean',
        ]);

        $user = User::create($validatedData);
        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'string|max:255',
            'password' => 'string|min:8',
            'nationalCode' => 'string|max:10',
            'phone' => 'string|max:20',
            'email' => 'email|max:255',
            'is_blocked' => 'boolean',
        ]);

        $user = User::findOrFail($id);
        $user->update($validatedData);
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
