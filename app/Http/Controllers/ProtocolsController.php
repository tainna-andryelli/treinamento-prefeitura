<?php

namespace App\Http\Controllers;

use App\Models\Protocols;
use App\Models\People;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProtocolsController extends Controller
{
    public function index()
    {
        $protocols = Protocols::all();
        $people = People::all();
        return Inertia::render('Protocols/Protocols', ['protocols' => $protocols, 'people' => $people]);
    }

    public function create()
    {
        $people = People::select('id', 'name')->get();
        return Inertia::render('Protocols/RegisterProtocols', ['people' => $people]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required',
            'created_date' => 'required|date',
            'deadline_days' => 'required|numeric',
            'contributor_id' => 'required|exists:people,id',
        ]);

        Protocols::create($validatedData);
    }

    public function edit(string $number)
    {
        $protocol = Protocols::find($number);
        $people = People::select('id', 'name')->get();
        return Inertia::render('Protocols/EditProtocols', ['protocol' => $protocol, 'people' => $people]); 
    }

    public function update(Request $request, string $number)
    {
        $protocol = Protocols::find($number);
        $validatedData = $request->validate([
            'description' => 'required',
            'created_date' => 'required|date',
            'deadline_days' => 'required|numeric',
            'contributor_id' => 'required|exists:people,id',
        ]);

        $protocol->update($validatedData);
    }

    public function destroy(string $number)
    {
        Protocols::destroy($number);
    }
}
