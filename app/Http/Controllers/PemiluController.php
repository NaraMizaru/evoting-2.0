<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Pemilu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PemiluController extends Controller
{
    public function managePemilu()
    {
        $pemilu = Pemilu::orderBy('created_at', 'ASC')->get();

        confirmDelete('Hapus Pemilu', 'Apakah kamu yakin ingin menghapus pemilu?');
        return view('manage.pemilu', compact([
            'pemilu'
        ]), ['menu_type' => 'manage-pemilu']);
    }

    public function addPemilu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'is_private' => 'required',
            'password' => 'required_if:is_private,1',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $toLower = strtolower($request->name);
        $slug = str_replace([' ', '/'], '-', $toLower);

        $pemilu = new Pemilu();
        $pemilu->name = $request->name;
        $pemilu->slug = $slug;
        $pemilu->description = $request->description;
        $pemilu->is_private = (int)$request->is_private;
        $pemilu->password = $request->password;
        $pemilu->status = (int)$request->status;
        $pemilu->save();

        return redirect()->back()->with('success', 'Pemilu berhasil ditambahkan');
    }

    public function kandidatPemilu($slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang dicari tidak ditemukan');
        }

        $kandidat = Kandidat::where('pemilu_id', $pemilu->id)->get();

        confirmDelete('Hapus Kandidat', 'Apakah kamu yakin ingin menghapus kandidat?');
        return view('manage.pemilu-kandidat', compact([
            'pemilu',
            'kandidat'
        ]), ['menu_type' => 'manage-pemilu']);
    }

    public function addKandidatPemilu($slug, Request $request)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang dicari tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'vision_mission' => 'required',
            'image' => 'required|file|image|mimes:png,jpg,jpeg'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $fileName = Str::random(8) . '.' . $request->file('image')->getClientOriginalExtension();

        $kandidat = new Kandidat();
        $kandidat->name = $request->name;
        $kandidat->description = $request->description;
        $kandidat->vision_mission = $request->vision_mission;
        $kandidat->image = $request->file('image')->storeAs('pemilu/' . $pemilu->slug, $fileName);
        $kandidat->pemilu_id = $pemilu->id;
        $kandidat->save();

        return redirect()->back()->with('success', 'Kandidat berhasil ditambahkan');
    }
}
