<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\InvoiceController;

Route::get('/', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('admin.register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login');
Route::middleware(['auth'])->prefix('dashboard/customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');

});
Route::middleware(['auth', 'role:admin'])->prefix('dashboard/invoices')->name('invoices.')->group(function() {
    Route::post('/', [InvoiceController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('edit');
    Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
});
Route::middleware(['auth'])->prefix('dashboard/invoices')->name('invoices.')->group(function() {
    Route::put('/{id}', [InvoiceController::class, 'update'])->name('update');
    Route::get('/', [InvoiceController::class, 'index'])->name('index');
    Route::get('invoices/search', [InvoiceController::class, 'searchInvoices'])->name('invoices.search');
    Route::get('logs', [InvoiceController::class, 'showLogs'])->name('logs.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
