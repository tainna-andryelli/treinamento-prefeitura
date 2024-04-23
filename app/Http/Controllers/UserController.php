<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $userAuth = Auth::user();
        return Inertia::render('Users/Users', ['users' => $users, 'userAuth' => $userAuth]);
    }

    public function create()
    {
        $userAuth = Auth::user();
        return Inertia::render('Users/RegisterUsers', ['userAuth' => $userAuth]);
    }

    public function store(UserRequest $request)
    {
        $validatedData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile' => $request->profile,
            'cpf' => $request->cpf,
            'active' => $request->active,
        ];

        User::create($validatedData);
    }

    public function edit(string $id)
    {
        $user = User::find($id);
        $userAuth = Auth::user();
        return Inertia::render('Users/EditUsers', ['user' => $user, 'userAuth' => $userAuth]);
    }

    public function update(UserRequest $request, string $id)
    {
        $user = User::find($id);
        $validatedData = [
            'name' => $request->name,
            'profile' => $request->profile,
            'active' => $request->active,
        ];

        $user->update($validatedData);
    }
}
