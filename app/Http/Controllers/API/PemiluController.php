<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\Pemilu;
use App\Models\User;
use Illuminate\Http\Request;

class PemiluController extends Controller
{
    public function getPemilu($slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return response()->json(['message' => 'Pemilu not found'], 404);
        }

        return response()->json($pemilu);
    }

    public function getKandidat($slug, $id)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return response()->json(['message' => 'Pemilu not found'], 404);
        }

        $kandidat = Kandidat::where('id', $id)->where('pemilu_id', $pemilu->id)->first();
        if (!$kandidat) {
            return response()->json(['message' => 'Kandidat not found'], 404);
        }

        return response()->json($kandidat);
    }

    public function getResultVoting($slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return response()->json(['message' => 'Pemilu not found'], 404);
        }

        $kandidat = Kandidat::where('pemilu_id', $pemilu->id)->withCount('voting')->get();

        if ($kandidat->isEmpty()) {
            return response()->json(['message' => 'Kandidat not found'], 404);
        }

        $labels = [];
        $data = [];

        foreach ($kandidat as $item) {
            $labels[] = $item->name;
            $data[] = $item->voting_count;
        }

        $totalUsers = User::count();
        $votedUsers = $pemilu->voting()->distinct('user_id')->count();
        $notVotedUsers = $totalUsers - $votedUsers;

        return response()->json([
            'total_users' => $totalUsers,
            'pie_charts' => [
                'voted' => $votedUsers,
                'not_voted' => $notVotedUsers,
            ],
            'bar_charts' => [
                'labels' => $labels,
                'data' => $data
            ],
        ]);
    }
}
