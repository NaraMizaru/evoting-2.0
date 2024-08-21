<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Pemilu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DashboarController extends Controller
{
    public function dashboard()
    {
        $pemilu = Pemilu::orderBy('created_at', 'DESC')->where('status', 1)->get();


        return view('dashboard', compact([
            'pemilu'
        ]), ['menu_type' => 'dashboard']);
    }

    public function joinPemilu($slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang dicari tidak ditemukan');
        }

        $kandidat = Kandidat::where('pemilu_id', $pemilu->id)->get();
        return view('join-pemilu', compact([
            'pemilu',
            'kandidat'
        ]), ['menu_type' => 'dashboard']);
    }

    public function verifyPassword(Request $request, $slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang dicari tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }


        if ($request->password == $pemilu->password) {
            Session::put('pemilu_' . $pemilu->slug . '_verified', true);
        } else {
            Alert::error('Error', 'Password Salah');
            return redirect()->back();
        }

        // dd(Session::get('pemilu_' . $pemilu->slug . '_verified'));
        return redirect()->route('user.pemilu.join', $slug);
    }
}
