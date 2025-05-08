<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthController;
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
Route::get('/profile/{user}', [UserController::class, 'show'])->name('profile');
Route::patch('/profile', [UserController::class, 'updateImage'])->name('user-updateImage');
Route::get('/profile-edit', [UserController::class, 'edit'])->name('user-edit');
Route::patch('/profile-edit', [UserController::class, 'update'])->name('user-update');


Route::get('/criar-servico', [ServiceController::class, 'create'])->name('service-create');
Route::post('/criar-servico', [ServiceController::class, 'store'])->name('service-store');
Route::get('/servico/{service}',[ServiceController::class,'show'])->name('service-show');
Route::get('/servicos',[ServiceController::class,'index'])->name('service-index');

});