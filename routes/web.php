<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('sobre');});

Route::get('/criar-conta', [UserController::class, 'create'])->name('user-create');
Route::post('/criar-conta', [UserController::class, 'store'])->name('user-insert');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['throttle:login-attempts'])->group(function () {
Route::post('/login', [AuthController::class, 'loginAtttempt'])->name('auth');
});





Route::middleware(['auth'])->group(function(){
// Paginas que só podem ser acessadas por usuarios logados
Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

});