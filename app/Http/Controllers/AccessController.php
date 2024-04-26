<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessRequest;
use App\Models\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccessController extends Controller
{
    public function store(AccessRequest $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'department_id' => $request->department_id,
        ];

        Access::create($data);
    }

    public function destroy(String $department_id, String $user_id)
    {
        $access = Access::where('department_id', $department_id)->where('user_id', $user_id)->first();
        if($access) {
            $access->delete();
        }
    }
}
