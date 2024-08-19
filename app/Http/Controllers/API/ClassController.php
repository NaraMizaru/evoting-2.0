<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function getClass($id)
    {
        $class = Kelas::where('id', $id)->first();

        return response()->json($class);
    }
}
