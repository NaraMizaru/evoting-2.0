<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

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

        if ($request->has('admin')) {
            $credentials = $request->only(['username', 'password']);
            $auth = Auth::attempt($credentials);

            if ($auth && Auth::user()->role == 'admin') {
                $user = Auth::user();
                Alert::success('Login successful', 'Happy Voting')->persistent(true);
                return redirect()->route('admin.dashboard')->with('status', 'Welcome to the dashboard, ' . $user->fullname);
            } else {
                return redirect()->back()->with('error', 'Username or password incorrect');
            }
        }

        $auth = Auth::attempt($request->only(['username', 'password']));
        if ($auth) {
            $user = Auth::user();
            return redirect()->route('user.dashboard')->with('status', 'Welcome to the dashboard, ' . $user->fullname);;
        } else {
            return redirect()->back()->with('error', 'Username or password incorrect');
        }
    }

    public function logout()
    {
        $authCheck = Auth::check();
        if (!$authCheck) {
            abort(401);
        }

        Auth::logout();
        Alert::success('Logout successful', "Thank's You For Voting")->persistent(true);
        return redirect()->route('view.login');
    }
}
