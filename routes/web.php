<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('sobre');});

Route::get('/criar-conta', [UserController::class, 'create'])->name('user-create');
Route::post('/criar-conta', [UserController::class, 'store'])->name('user-insert');
Route::get('/login', function () { return view('user-login'); })->name('user-login');
Route::post('/login', function () { return 'Autenticação do usuario'; })->name('login');
