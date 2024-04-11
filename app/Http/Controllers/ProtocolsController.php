<?php

namespace App\Http\Controllers;

use App\Models\Protocols;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProtocolsController extends Controller
{
    public function index()
    {
        return Inertia::render('Protocols/Protocols');
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
