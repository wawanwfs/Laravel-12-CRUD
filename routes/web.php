<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

# route dengan mode resources
Route::resource(name: '/products', controller: ProductController::class);

Route::get('/', [ProductController::class, 'index'])->name('dashboard');
