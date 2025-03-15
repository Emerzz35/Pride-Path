<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('sobre');});

Route::get('/criar-conta', function () { return view('user-create'); })->name('user-create');
Route::post('/criar-conta', function () { return 'validação e inserção do usuario'; })->name('user-insert');
