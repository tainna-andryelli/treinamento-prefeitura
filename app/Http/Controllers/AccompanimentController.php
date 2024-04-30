<?php

namespace App\Http\Controllers;

use App\Models\Accompaniment;
use Illuminate\Http\Request;
use App\Http\Requests\AccompanimentRequest;

class AccompanimentController extends Controller
{

    public function store(AccompanimentRequest $request)
    {
        $data = [
            'description' => $request->description,
            'status' => $request->status,
            'protocol_number' => $request->protocol_number,
        ];
    
        Accompaniment::create($data);
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
