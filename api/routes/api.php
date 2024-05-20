<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', App\Http\Controllers\AuthController::class)->name('daftar');
Route::post('/login', App\Http\Controllers\AuthController::class)->name('masuk');

Route::middleware(['userRoleOnly:admin,user'])->group(function () {
    Route::get('/products', App\Http\Controllers\Api\ProductController::class)->name('ambilSemua');
    Route::post('/products', App\Http\Controllers\Api\ProductController::class)->name('tambah');

    Route::delete('/products/{id}', App\Http\Controllers\Api\ProductController::class)->name('hapus');
    Route::put('/products/{id}', App\Http\Controllers\Api\ProductController::class)->name('ubah');
    Route::get('/products/{id}', App\Http\Controllers\Api\ProductController::class)->name('ambil');
});

Route::middleware(['userRoleOnly:admin'])->group(function () {
    Route::get('/categories', App\Http\Controllers\Api\CategoryController::class)->name('ambilSemua');
    Route::post('/categories', App\Http\Controllers\Api\CategoryController::class)->name('tambah');

    Route::get('/categories/{id}', App\Http\Controllers\Api\CategoryController::class)->name('ambil');
    Route::delete('/categories/{id}', App\Http\Controllers\Api\CategoryController::class)->name('hapus');
    Route::put('/categories/{id}', App\Http\Controllers\Api\CategoryController::class)->name('ubah');
});
