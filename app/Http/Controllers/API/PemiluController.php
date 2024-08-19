<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\Pemilu;
use Illuminate\Http\Request;

class PemiluController extends Controller
{
    public function getKandidat($slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return response()->json(['message' => 'Pemilu not found'], 404);
        }

        $kandidat = Kandidat::where('pemilu_id', $pemilu->id)->first();
        if (!$kandidat) {
            return response()->json(['message' => 'Kandidat not found'], 404);
        }

        return response()->json($kandidat);
    }
}
