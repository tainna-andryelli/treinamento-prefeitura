<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentsController extends Controller
{
    public function index()
    {
        $departments = Departments::all();
        return Inertia::render('Departments/Departments', ['departments' => $departments]);
    }

    public function create()
    {
        return Inertia::render('Departments/RegisterDepartments');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', 
        ]);

        Departments::create($validatedData);
    }

    public function edit(String $id)
    {
        $department = Departments::find($id);
        return Inertia::render('Departments/EditDepartments', ['department' => $department]);
    }

    public function update(Request $request, String $id)
    {
        $department = Departments::find($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', 
        ]);

        $department->update($validatedData);

    }

    public function destroy(Departments $departments)
    {
        //
    }
}
