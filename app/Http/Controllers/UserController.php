<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('Users/Users', ['users' => $users]);
    }

    public function create()
    {
        return Inertia::render('Users/UsersRegister');
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

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
