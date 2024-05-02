<?php

namespace App\Http\Controllers;

use App\Models\Accompaniment;
use App\Models\Departments;
use Illuminate\Http\Request;
use App\Models\Protocols;
use App\Models\People;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function generateSpecificProtocolPdf($number)
    {
        $protocol = Protocols::findOrFail($number);
        $accompaniments = Accompaniment::where('protocol_number', $number)->get();
        $contributor = People::findOrFail($protocol->contributor_id);
        $department = Departments::findOrFail($protocol->department_id);

        if($protocol->status === 'A') {
            $status = 'Aberto';
        } else if($protocol->status === 'E') {
            $status = 'Em atendimento';
        } else {
            $status = 'Solucionado';
        }

        $createdDate = Carbon::parse($protocol->created_date);
        $deadlineDate = $createdDate->addDays($protocol->deadline_days)->format('Y-m-d');

        $html = view('pdf\analyticalPdf', [
            'protocol' => $protocol, 
            'accompaniments' => $accompaniments, 
            'contributor' => $contributor, 
            'department' => $department, 
            'status' => $status,
            'deadline_date' => $deadlineDate
            ])->render();
    
        return PDF::loadHtml($html)->download('protocolo_' . $number . '.pdf');
    }

    public function generateAllProtocolsPdf()
    {
        $protocols = Protocols::all();
        $people = People::all();

        $html = view('pdf\syntheticPdf', ['protocols' => $protocols, 'people' => $people])->render();
    
        return PDF::loadHtml($html)->download('protocolos.pdf');
    }
}
