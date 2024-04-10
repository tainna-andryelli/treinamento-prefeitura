<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeopleRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\People;
use Carbon\Carbon;

class PeopleController extends Controller
{
    public function index()
    {
        $people = People::all();
        return Inertia::render('People/People', ['people' => $people]);
    }

    public function create()
    {
        return Inertia::render('People/RegisterPeople');
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


    public function show(string $id)
    {
        $person = People::find($id);
        return Inertia::render('People/EditPeople', ['person' => $person]);
    }

    public function edit(string $id)
    {
        //
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
