<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboarController;
use App\Http\Controllers\PemiluController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('post.logout');

    Route::get('/dashboard', [DashboarController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/manage/class', [ClassController::class, 'manageClass'])->name('admin.manage.class');
    Route::post('/manage/class/add', [ClassController::class, 'addClass'])->name('admin.manage.class.add');
    Route::post('/manage/class/import', [ClassController::class, 'importClass'])->name('admin.manage.class.import');
    Route::post('/manage/class/{id}/update', [ClassController::class, 'updateClass'])->name('admin.manage.class.update');
    Route::delete('/manage/class/{slug}/delete', [ClassController::class, 'deleteClass'])->name('admin.manage.class.delete');

    Route::get('/manage/users', [UserController::class, 'manageUser'])->name('admin.manage.users');
    Route::post('/manage/user/add', [UserController::class, 'addUser'])->name('admin.manage.user.add');
    Route::post('/manage/user/import', [UserController::class, 'importUser'])->name('admin.manage.user.import');
    Route::get('/manage/user/export', [UserController::class, 'exportUser'])->name('admin.manage.user.export');
    Route::post('/manage/user/{id}/update', [UserController::class, 'updateUser'])->name('admin.manage.user.update');
    Route::delete('/manage/user/{username}/delete', [UserController::class, 'deleteUser'])->name('admin.manage.user.delete');

    Route::get('/manage/pemilu', [PemiluController::class, 'managePemilu'])->name('admin.manage.pemilu');
    Route::post('/manage/pemilu/add', [PemiluController::class, 'addPemilu'])->name('admin.manage.pemilu.add');

    Route::get('/manage/pemilu/{slug}/kandidat', [PemiluController::class, 'kandidatPemilu'])->name('admin.manage.pemilu.kandidat');
    Route::post('/manage/pemilu/{slug}/kandidat/add', [PemiluController::class, 'addKandidatPemilu'])->name('admin.manage.pemilu.kandidat.add');
});
