<?php

namespace App\Http\Controllers;

use App\Models\Accompaniment;
use Illuminate\Http\Request;
use App\Http\Requests\AccompanimentRequest;
use App\Models\Protocols;

class AccompanimentController extends Controller
{

    public function store(AccompanimentRequest $request, String $number)
    {
        $data = [
            'description' => $request->description,
            'status' => $request->status,
            'protocol_number' => $request->protocol_number,
        ];
        
        $protocol = Protocols::findOrFail($number);

        if($request->status != $protocol->status){
            $protocol->status = $request->status;
            $protocol->save();
        }

        Accompaniment::create($data);
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
