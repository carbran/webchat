<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
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

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/users',[UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}',[UserController::class, 'show'])->name('users.show');

    Route::get('/messages/{user}', [MessageController::class, 'listMessages'])->name('messages.listMessages');
    Route::post('/messages/store', [MessageController::class, 'store'])->name('messages.store');
});