<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser($id)
    {
        $user = User::where('id', $id)->first();

        return response()->json($user);
    }
}
