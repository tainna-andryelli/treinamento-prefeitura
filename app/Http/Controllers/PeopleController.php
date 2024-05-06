<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeopleRequest;
use Inertia\Inertia;
use App\Models\People;
use Illuminate\Support\Facades\Auth;

class PeopleController extends Controller
{
    public function index()
    {
        $people = People::all();
        $userProfile = Auth::user()->profile;
        
        return Inertia::render('People/People', ['people' => $people, 'userProfile' => $userProfile]);
    }

    public function create()
    {
        $userProfile = Auth::user()->profile;

        return Inertia::render('People/RegisterPeople', ['userProfile' => $userProfile]);
    }

    public function store(PeopleRequest $request)
    {
        $data = [
            'name' => $request->name,
            'birthday' => $request->birthday,
            'cpf' => $request->cpf,
            'sex' => $request->sex,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
        ];

        People::create($data);
    }

    public function edit(string $id)
    {
        $person = People::find($id);
        $userProfile = Auth::user()->profile;

        return Inertia::render('People/EditPeople', ['person' => $person, 'userProfile' => $userProfile]);
    }

    public function update(PeopleRequest $request, string $id)
    {
        $person = People::find($id);
        $data = [
            'name' => $request->name,
            'birthday' => $request->birthday,
            'cpf' => $request->cpf,
            'sex' => $request->sex,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
        ];

        $person->update($data);
    }

    public function destroy(string $id)
    {
        People::destroy($id);
    }
}
