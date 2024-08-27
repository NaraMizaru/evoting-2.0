<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use App\Models\Kelas;
use App\Models\Notification;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function copyright(Request $request){
        $notification = Notification::latest()->limit(5)->get();
        $notificationCount = Notification::count();
        return view("manage.copyright", compact([
            'notification',
            'notificationCount'
        ]), ['menu_type' => '']);

    }
    public function manageUser()
    {
        $user = User::where('role', '!=', 'admin')->orderBy('kelas_id', 'asc')->get();
        $kelas = Kelas::orderBy('name', 'asc')->get();
        $notification = Notification::latest()->limit(5)->get();
        $notificationCount = Notification::count();

        confirmDelete('Hapus User', 'Apakah kamu yakin ingin menghapus user?');
        return view('manage.users', compact([
            'user',
            'kelas',
            'notification',
            'notificationCount'
        ]), ['menu_type' => 'manage-user']);
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'username' => 'required|min:3',
            'password' => 'required|min:4',
            'role' => 'required',
            'kelas_id' => 'required_if:role,siswa'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->password =  bcrypt($request->password);
        $user->unencrypted_password = $request->password;
        $user->role = $request->role;
        $user->kelas_id = $request->kelas_id;
        $user->save();

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User yang ingin diubah tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'username' => 'required|min:3',
            'password' => 'required|min:4',
            'role' => 'required',
            'kelas_id' => 'required_if:role,siswa'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        if ($request->role != 'siswa') {
            $request->merge(['kelas_id' => null]);
        }

        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->password =  bcrypt($request->password);
        $user->unencrypted_password = $request->password;
        $user->role = $request->role;
        $user->kelas_id = $request->kelas_id;
        $user->save();

        return redirect()->back()->with('success', 'User berhasil diubah');
    }

    public function importUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx,xls',
            'role' => 'required',
            'kelas_id' => 'required_if:role,siswa',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        Excel::import(new UserImport($request->kelas_id ?? NULL, $request->role), $request->file('file'));

        return redirect()->back()->with('success', 'Data user berhasil diimport');
    }

    public function exportUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'kelas_id' => 'required_if:role,siswa'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $kelas = Kelas::where('id', $request->kelas_id)->first();

        if ($request->role == 'siswa') {
            $users = User::where('kelas_id', $request->kelas_id)->get();
        } else if ($request->role == 'guru') {
            $users = User::where('role', 'guru')->get();
        } else if ($request->role == 'caraka') {
            $users = User::where('role', 'caraka')->get();
        }

        $pdf = Pdf::loadView('export.export-users', compact('users'));
        if ($request->role == 'siswa') {
            return $pdf->download('Data User Evoting ' . $kelas->name . '.pdf');
        } else if ($request->role == 'guru') {
            return $pdf->download('Data User Evoting Guru' . '.pdf');
        } else if ($request->role == 'caraka') {
            return $pdf->download('Data User Evoting Caraka' . '.pdf');
        }
    }

    public function deleteUser($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User yang ingin dihapus tidak ditemukan');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
