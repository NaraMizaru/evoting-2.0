<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'indexLogin'])->name('view.login');
Route::post('/login', [AuthController::class, 'login'])->name('post.login');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('/dashboard', [DashboarController::class, 'dashboard'])->name('admin.dashboard');
});
