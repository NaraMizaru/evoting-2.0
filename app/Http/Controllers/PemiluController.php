<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Notification;
use App\Models\Pemilu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PemiluController extends Controller
{
    public function managePemilu()
    {
        $user = Auth::user();
        $pemilu = Pemilu::orderBy('created_at', 'DESC')->where('user_id', $user->id)->get();
        $notificationCount = Notification::count();
        $notification = Notification::latest()->limit(5)->get();

        // $kandidat = Kandidat::where('pemilu_id', )

        confirmDelete('Hapus Pemilu', 'Apakah kamu yakin ingin menghapus pemilu?');
        return view('manage.pemilu', compact([
            'pemilu',
            'notification',
            'notificationCount'
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

        if ($request->is_private == 0) {
            $request->merge(['password' => null]);
        }

        $pemilu = new Pemilu();
        $pemilu->name = $request->name;
        $pemilu->slug = $slug;
        $pemilu->description = $request->description;
        $pemilu->is_private = (int)$request->is_private;
        $pemilu->password = $request->password;
        $pemilu->status = (int)$request->status;
        $pemilu->user_id = Auth::user()->id;
        $pemilu->save();

        return redirect()->back()->with('success', 'Pemilu berhasil ditambahkan');
    }

    public function updatePemilu(Request $request, $slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang dicari tidak ditemukan');
        }

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

        if ($request->is_private == 0) {
            $request->merge(['password' => null]);
        }

        $pemilu->name = $request->name;
        $pemilu->slug = $slug;
        $pemilu->description = $request->description;
        $pemilu->is_private = (int)$request->is_private;
        $pemilu->password = $request->password;
        $pemilu->status = (int)$request->status;
        $pemilu->user_id = Auth::user()->id;
        $pemilu->save();

        return redirect()->back()->with('success', 'Pemilu berhasil diubah');
    }

    public function deletePemilu($slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang ingin dihapus tidak ditemukan');
        }

        $user = Auth::user();
        if ($user->id != $pemilu->user_id) {
            Alert::warning('Akses Terlarang', 'Anda tidak memiliki akses');
            return redirect()->back();
        }

        $pemilu->delete();
        return redirect()->back()->with('success', 'Pemilu berhasil dihapus');
    }

    public function kandidatPemilu($slug)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();
        $notificationCount = Notification::count();
        $notification = Notification::latest()->limit(5)->get();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang dicari tidak ditemukan');
        }

        $user = Auth::user();

        if ($user->id != $pemilu->user_id) {
            Alert::warning('Akses Terlarang', 'Anda tidak memiliki akses');
            return redirect()->back();
        }

        $kandidat = Kandidat::where('pemilu_id', $pemilu->id)->get();

        confirmDelete('Hapus Kandidat', 'Apakah kamu yakin ingin menghapus kandidat?');
        return view('manage.pemilu-kandidat', compact([
            'pemilu',
            'kandidat',
            'notification',
            'notificationCount'
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

    public function updateKandidatPemilu(Request $request,  $slug, $id)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang dicari tidak ditemukan');
        }

        $kandidat = Kandidat::where('id', $id)->where('pemilu_id', $pemilu->id)->first();

        if (!$kandidat) {
            return redirect()->back()->with('error', 'Kandidat yang dicari tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'vision_mission' => 'required',
            'image' => 'nullable|file|image|mimes:png,jpg,jpeg'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $kandidat->name = $request->name;
        $kandidat->description = $request->description;
        $kandidat->vision_mission = $request->vision_mission;

        if ($request->hasFile('image')) {
            $fileName = Str::random(8) . '.' . $request->file('image')->getClientOriginalExtension();
            $kandidat->image = $request->file('image')->storeAs('pemilu/' . $pemilu->slug, $fileName);
        }

        $kandidat->save();

        return redirect()->back()->with('success', 'Kandidat berhasil diubah');
    }

    public function deleteKandidatPemilu($slug, $id)
    {
        $pemilu = Pemilu::where('slug', $slug)->first();

        if (!$pemilu) {
            return redirect()->back()->with('error', 'Pemilu yang dicari tidak ditemukan');
        }

        $kandidat = Kandidat::where('id', $id)->where('pemilu_id', $pemilu->id)->first();

        if (!$kandidat) {
            return redirect()->back()->with('error', 'Kandidat yang dicari tidak ditemukan');
        }

        $kandidat->delete();
        return redirect()->back()->with('success', 'Kandidat berhasil dihapus');
    }
}
