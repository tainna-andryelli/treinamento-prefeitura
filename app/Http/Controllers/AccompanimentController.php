<?php

namespace App\Http\Controllers;

use App\Models\Accompaniment;
use Illuminate\Http\Request;

class AccompanimentController extends Controller
{

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string',
            'status' => 'required|in:A,E,S',
            'protocol_number' => 'required|numeric',
        ]);
    
        Accompaniment::create($validatedData);
    }

    public function edit(Accompaniment $accompaniment)
    {
        //
    }

    public function update(Request $request, Accompaniment $accompaniment)
    {
        //
    }

    public function destroy(Accompaniment $accompaniment)
    {
        //
    }
}
