<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachedFilesRequest;
use App\Http\Requests\ProtocolsRequest;
use App\Models\Protocols;
use App\Models\People;
use App\Models\Departments;
use App\Models\AttachedFile;
use App\Models\Access;
use App\Models\Accompaniment;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProtocolsController extends Controller
{
    public function index()
    {
        $userAuth = Auth::user();
        
        if($userAuth && $userAuth->profile === 'A'){
            $access = Access::where('user_id', $userAuth->id )->pluck('department_id')->toArray();
            $protocols = Protocols::whereIn('department_id', $access)->get();
            $departments = Departments::whereIn('id', $access)->get();
        } else {
            $protocols = Protocols::all();
            $departments = Departments::all();
        }
        
        $people = People::all();

        return Inertia::render('Protocols/Protocols', ['protocols' => $protocols, 'people' => $people, 'departments' => $departments]);
    }

    public function create()
    {
        $userAuth = Auth::user();

        if ($userAuth && $userAuth->profile === 'A') {
            $access = Access::where('user_id', $userAuth->id)->pluck('department_id')->toArray();
            $departments = Departments::whereIn('id', $access)->select('id', 'name')->get();
        } else {
            $departments = Departments::select('id', 'name')->get();
        }

        $people = People::select('id', 'name')->get();

        return Inertia::render('Protocols/RegisterProtocols', ['people' => $people, 'departments' => $departments]);
    }

    public function store(ProtocolsRequest $request)
    {
        $data = [
            'description' => $request->description,
            'created_date' => $request->created_date,
            'deadline_days' => $request->deadline_days,
            'contributor_id' => $request->contributor_id,
            'department_id' => $request->department_id,
            'status' => $request->status,
        ];

        $protocol = Protocols::create($data);
        
        if ($protocol && $request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName(); //guarantees unique filenames
                $storagePath = $file->storeAs('protocols', $filename);

                AttachedFile::create([
                    'protocol_number' => $protocol->number,
                    'filename' => $filename,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'filepath' => $storagePath
                ]);
            }
        }
    }

    public function edit(string $number)
    {
        $protocol = Protocols::find($number);
        $people = People::select('id', 'name')->get();
        $files = AttachedFile::where('protocol_number', $number)->get();
        $accompaniments = Accompaniment::where('protocol_number', $number)->orderBy('created_at', 'desc')->get();

        $userAuth = Auth::user();
        if($userAuth->profile === 'A') {
            $access = Access::where('user_id', $userAuth->id)->pluck('department_id')->toArray();
            $departments = Departments::whereIn('id', $access)->select('id', 'name')->get();
        } else{
            $departments = Departments::select('id', 'name')->get();
        }
        return Inertia::render('Protocols/EditProtocols', ['protocol' => $protocol, 'people' => $people, 'files' => $files, 'departments' => $departments, 'accompaniments' => $accompaniments]); 
    }

    public function update(ProtocolsRequest $request, string $number)
    {
        $protocol = Protocols::find($number);

        $data = [
            'description' => $request->description,
            'created_date' => $request->created_date,
            'deadline_days' => $request->deadline_days,
            'contributor_id' => $request->contributor_id,
            'department_id' => $request->department_id,
            'status' => $request->status,
        ];

        $protocol->update($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName(); //guarantees unique filenames
                $storagePath = $file->storeAs('protocols', $filename);

                AttachedFile::create([
                    'protocol_number' => $protocol->number,
                    'filename' => $filename,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'filepath' => $storagePath
                ]);
            }
        }
    }

    public function destroy(string $number)
    {
        Protocols::destroy($number);
    }

    public function uploadFile(AttachedFilesRequest $request, $protocolNumber) {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName(); //garante filenames únicos
                $storagePath = $file->storeAs('protocols', $filename);

                AttachedFile::create([
                    'protocol_number' => $protocolNumber,
                    'filename' => $filename,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'filepath' => $storagePath
                ]);
            }
        }
    }

    public function destroyFile(string $id) 
    {
        AttachedFile::destroy($id);
    }

    public function downloadFile(string $id){
        $file = AttachedFile::find($id);
        return Storage::download($file->filepath, $file->filename);
    }
}