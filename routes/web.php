<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;


Route::get('/sobre', function () { 
    return view('sobre');
})->name('sobre');

Route::get('/criar-conta', [UserController::class, 'create'])->name('user-create');
Route::post('/criar-conta', [UserController::class, 'store'])->name('user-insert');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/',[ServiceController::class,'index'])->name('service-index');

Route::middleware(['throttle:login-attempts'])->group(function () {
Route::post('/login', [AuthController::class, 'loginAtttempt'])->name('auth');
});

// Add these routes after the login routes but before the auth middleware group
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');





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
Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('service-destroy');
Route::get('/servico/{service}',[ServiceController::class,'show'])->name('service-show');


Route::post('/fazer-pedido', [OrderController::class, 'store'])->name('order-store');
Route::get('/meus-pedidos', [OrderController::class, 'list'])->name('order-list');
Route::get('/minhas-entregas', [OrderController::class, 'received'])->name('order-received');
Route::post('/aceitar', [OrderController::class, 'accept'])->name('order-accept');
Route::post('/negar', [OrderController::class, 'deny'])->name('order-deny');
Route::post('/entregar', [OrderController::class, 'comission'])->name('order-comission');

Route::post('/report', [ReportController::class, 'store'])->name('report-store');
Route::get('/admin/reports', [ReportController::class, 'index'])->name('report-index');
Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('report-destroy');


Route::post('/servico/{service}/rate', [RatingController::class, 'store'])->name('service-rate');
Route::delete('/services/{serviceId}/rating/{userId?}', [RatingController::class, 'destroy'])->name('rating-destroy');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

});
