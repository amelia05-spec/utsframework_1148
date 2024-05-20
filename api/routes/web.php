<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return response()->view('welcome');
});

Route::get('/api/oauth/register', 'App\Http\Controllers\AuthController@oauthAlihkan');
Route::get('/api/oauth/callback', 'App\Http\Controllers\AuthController@oauthPanggilanBalik');
