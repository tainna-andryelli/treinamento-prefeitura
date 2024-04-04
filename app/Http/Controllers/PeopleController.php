<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\People;
use Carbon\Carbon;

class PeopleController extends Controller
{
    public function index()
    {
        $people = People::paginate(10);
        return Inertia::render('People', ['people' => $people]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
