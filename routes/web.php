<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/orders', [OrderController::class, 'index'])
    ->middleware('auth')
    ->name('orders.index');

Route::get('/orders/create', [OrderController::class, 'create'])
    ->middleware('auth')
    ->name('orders.create');

Route::post('/orders', [OrderController::class, 'store'])
    ->middleware('auth')
    ->name('orders.store');

Route::post('/orders/{order}/payments', [
    PaymentController::class,
    'store',
    ])->middleware('auth')->name('payments.store');

Route::get('/orders/{order}/payments/create', [
    PaymentController::class,
    'create',
    ])->middleware('auth')->name('payments.create');

require __DIR__.'/auth.php';
