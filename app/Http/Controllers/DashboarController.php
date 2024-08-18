<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboarController extends Controller
{
    public function dashboard()
    {
        return view('dashboard', compact([]), ['menu_type' => 'dashboard']);
    }
}
