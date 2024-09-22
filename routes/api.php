<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;

/*
|------------------------------------------------------------------
| API Routes
|------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::post('/', [CustomerController::class, 'store']);
        Route::get('/{id}', [CustomerController::class, 'show']);
        Route::put('/{id}', [CustomerController::class, 'update']);
        Route::delete('/{id}', [CustomerController::class, 'destroy']);
    });
    Route::get('/searchInvoices', [InvoiceController::class, 'searchInvoices']);
    Route::get('/showLogs', [InvoiceController::class, 'showLogs']);

    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index']);
        Route::get('/{id}', [InvoiceController::class, 'show']);

        Route::middleware('role:admin')->group(function () {
            Route::post('/', [InvoiceController::class, 'store']);
            Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);
            Route::put('/invoices/{id}', [InvoiceController::class, 'update']);
        });

        Route::middleware('role:employee')->group(function () {
            Route::put('/invoices/{id}', [InvoiceController::class, 'update']);
        });
    });
});
