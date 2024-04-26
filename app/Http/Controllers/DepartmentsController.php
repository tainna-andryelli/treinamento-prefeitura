<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Departments;
use App\Models\User;
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

        $users = User::all();

        $access = Access::where('department_id', $id)->get();
        $usersInAccess = $access->pluck('user_id')->unique()->toArray();
        $usersInAccessNames = User::whereIn('id', $usersInAccess)->get(); 

        return Inertia::render('Departments/EditDepartments', ['department' => $department, 'users' => $users, 'access' => $access, 'usersInAccess'=> $usersInAccessNames]);
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
