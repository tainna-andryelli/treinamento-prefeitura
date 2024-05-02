<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;

class AuditsController extends Controller
{
    public function index()
    {
        $audits = Audit::orderBy('created_at', 'desc')->get();
        $users = User::all();
        return Inertia::render('Audits/Audits', ['audits' => $audits, 'users' => $users]);
    }

    public function show(string $id)
    {
        $audit = Audit::findOrFail($id);
        $user = User::findOrFail($audit->user_id);
        return Inertia::render('Audits/ShowAudit', ['audit' => $audit, 'user' => $user]);
    }
}
