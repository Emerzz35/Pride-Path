<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RatingController;
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
Route::delete('/profile/{id}', [UserController::class, 'destroy'])->name('user-destroy');


Route::get('/criar-servico', [ServiceController::class, 'create'])->name('service-create');
Route::post('/criar-servico', [ServiceController::class, 'store'])->name('service-store');
Route::patch('/servico/{service}', [ServiceController::class, 'update'])->name('service-update');
Route::get('/servico/{service}',[ServiceController::class,'show'])->name('service-show');
Route::get('/servicos',[ServiceController::class,'index'])->name('service-index');
Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('service-destroy');


Route::post('/fazer-pedido', [OrderController::class, 'store'])->name('order-store');
Route::get('/meus-pedidos', [OrderController::class, 'list'])->name('order-list');
Route::get('/minhas-entregas', [OrderController::class, 'received'])->name('order-received');
Route::post('/aceitar', [OrderController::class, 'accept'])->name('order-accept');
Route::post('/negar', [OrderController::class, 'deny'])->name('order-deny');
Route::post('/entregar', [OrderController::class, 'comission'])->name('order-comission');

Route::post('/report', [ReportController::class, 'store'])->name('report-store');
Route::get('/admin/reports', [ReportController::class, 'index'])->name('report-index');

Route::post('/servico/{service}/rate', [RatingController::class, 'store'])->name('service-rate');

});


    

