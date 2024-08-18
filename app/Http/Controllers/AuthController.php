<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function indexLogin(Request $request)
    {
        $isAdmin = $request->has('admin');
        $adminLoggedIn = $isAdmin ? 'admin' : '';

        return view('auth.login', compact(['adminLoggedIn']));
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'password' => 'required|min:4'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $admin = User::where('role', 'admin')->first();
        if ($request->username == $admin->username && $request->password == $admin->unencrypted_password && $request->has('admin')) {
            $auth = Auth::attempt($request->only(['username', 'password']));
            if ($auth) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->back()->with('error', 'Username or password incorrect');
            }
        } else if ($request->username == $admin->username && $request->password == $admin->unencrypted_password && !$request->has('admin')) {
            return redirect()->back()->with('error', 'Username or password incorrect');
        }

        $auth = Auth::attempt($request->only(['username', 'password']));
        if ($auth) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error', 'Username or password incorrect');
        }
    }
}
