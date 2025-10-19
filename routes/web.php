<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\CustomerController;

Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
