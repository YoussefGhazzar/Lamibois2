<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;

Route::post('/contact', [ContactController::class, 'store']);

Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);
Route::put('/products/{product}',    [ProductController::class, 'update']);

Route::post('/login', [LoginController::class, 'login']);