<?php

namespace App\Http\Controllers;

use App\Models\Accompaniment;
use Illuminate\Http\Request;
use App\Models\Protocols;
use App\Models\People;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generateSpecificProtocolPdf($number)
    {
        $protocol = Protocols::findOrFail($number);
        $accompaniments = Accompaniment::where('protocol_number', $number)->get();
        $contributor = People::findOrFail($protocol->contributor_id);

        $html = view('pdf\protocolPdf', ['protocol' => $protocol, 'accompaniments' => $accompaniments, 'contributor' => $contributor])->render();
    
        return PDF::loadHtml($html)->download('protocolo_' . $number . '.pdf');
    }

    public function generateAllProtocolsPdf()
    {
        $protocols = Protocols::all();

        $html = view('pdf\protocolsPdf', ['protocols' => $protocols])->render();
    
        return PDF::loadHtml($html)->download('protocolos.pdf');
    }
}
