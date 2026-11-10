<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('customers.index')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth'])->group(function () {

    // Dashboard khusus admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('users', UserController::class)
            ->except(['show']);

        Route::post('/invoices/{invoice}/pay', [InvoiceController::class, 'pay'])
            ->name('invoices.pay');

        Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])
            ->name('invoices.destroy');

        Route::get('/invoices/create', [InvoiceController::class, 'create'])
            ->name('invoices.create');

        Route::post('/invoices', [InvoiceController::class, 'store'])
            ->name('invoices.store');
    });

    // Fitur yang dapat diakses admin dan staff
    Route::resource('customers', CustomerController::class)
        ->except(['destroy']);

    // Penghapusan pelanggan khusus admin
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('customers.destroy');

    // Invoice hanya dapat dilihat admin dan staff
    Route::get('/invoices', [InvoiceController::class, 'index'])
        ->name('invoices.index');

    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])
        ->name('invoices.show');
});
