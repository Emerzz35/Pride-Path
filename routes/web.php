<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('sobre');});

Route::get('/criar-conta', function () { return view('user-create'); })->name('user-create');
Route::post('/criar-conta', function () { return 'validação e inserção do usuario'; })->name('user-insert');
Route::get('/login', function () { return view('user-login'); })->name('user-login');
Route::post('/login', function () { return 'Autenticação do usuario'; })->name('login');
