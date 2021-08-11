<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/upload', [CustomerController::class, 'index'])->name('upload');
Route::post('/upload', [CustomerController::class, 'store']);
