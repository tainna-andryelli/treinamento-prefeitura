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
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Protocols $protocols)
    {
        //
    }

    public function edit(Protocols $protocols)
    {
        //
    }

    public function update(Request $request, Protocols $protocols)
    {
        //
    }

    public function destroy(Protocols $protocols)
    {
        //
    }
}
