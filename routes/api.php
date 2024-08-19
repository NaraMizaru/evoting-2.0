<?php

use App\Http\Controllers\API\ClassController;
use App\Http\Controllers\API\PemiluController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/class/{id}', [ClassController::class, 'getClass']);
Route::get('/user/{id}', [UserController::class, 'getUser']);
Route::get('/pemilu/{slug}/kandidat/{id}', [PemiluController::class, 'getKandidat']);
