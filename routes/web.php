<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

Route::get('/', [CustomerController::class, 'index'])->name('upload');
Route::post('/', [CustomerController::class, 'store']);
