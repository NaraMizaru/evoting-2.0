<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\DashboarController;
use App\Http\Controllers\PemiluController;
use App\Http\Controllers\ProfileController;
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
Route::post('/logout', [AuthController::class, 'logout'])->name('post.logout')->middleware('auth');
Route::get('/profile/me', [ProfileController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/update/profile/me', [ProfileController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::post('/update-image/profile/me', [ProfileController::class, 'updateProfileImage'])->name('profile.update.image')->middleware('auth');

Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function () {
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
    Route::post('/manage/pemilu/{slug}/edit', [PemiluController::class, 'updatePemilu'])->name('admin.manage.pemilu.edit');
    Route::delete('/manage/pemilu/{slug}/delete', [PemiluController::class, 'deletePemilu'])->name('admin.manage.pemilu.delete');

    Route::get('/manage/pemilu/{slug}/kandidat', [PemiluController::class, 'kandidatPemilu'])->name('admin.manage.pemilu.kandidat');
    Route::get('/manage/pemilu/{slug}/kandidat/export/result', [PemiluController::class, 'exportResultPdf'])->name('admin.manage.pemilu.export.result');
    Route::post('/manage/pemilu/{slug}/kandidat/add', [PemiluController::class, 'addKandidatPemilu'])->name('admin.manage.pemilu.kandidat.add');
    Route::post('/manage/pemilu/{slug}/kandidat/{id}/update', [PemiluController::class, 'updateKandidatPemilu'])->name('admin.manage.pemilu.kandidat.update');
    Route::delete('/manage/pemilu/{slug}/kandidat/{id}/delete', [PemiluController::class, 'deleteKandidatPemilu'])->name('admin.manage.pemilu.kandidat.delete');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'user'], function () {
    Route::get('/dashboard', [DashboarController::class, 'dashboard'])->name('user.dashboard');

    Route::get('/event/pemilu/{slug}/join', [DashboarController::class, 'joinPemilu'])->name('user.pemilu.join')->middleware('verify.pemilu.password');
    Route::post('/event/pemilu/{slug}/kandidat/{id}/vote', [DashboarController::class, 'votePemilu'])->name('user.pemilu.vote');
    Route::post('/pemilu/{slug}/verify-password/join', [DashboarController::class, 'verifyPasswordJoin'])->name('user.pemilu.verify-password.join');
});
