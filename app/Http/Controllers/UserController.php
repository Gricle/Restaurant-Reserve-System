<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'nationalCode' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'imgURL' => 'string|max:255',
            'is_blocked' => 'boolean',
        ]);

        $user = User::create($validatedData);
        return new UserResource($user);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
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
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    public function generateUsersPDF()
    {
        $users = User::select('username')->get();
        
        $pdf = Pdf::loadView('users.pdf', ['users' => $users]);
        
        return $pdf->download('users_list.pdf');
    }
}