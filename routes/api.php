<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/products', [ProductController::class, 'getAll']);

Route::get('/products/{id}', [ProductController::class, 'getById']);

Route::put('/products/{id}', [ProductController::class, 'update']);

Route::post('/products', [ProductController::class, 'create']);

Route::delete('/products/{id}', [ProductController::class, 'delete']);
