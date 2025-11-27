<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome'); // landing page Laravel
});

// Health check sederhana (bisa diakses lewat browser)
Route::get('/backend-info', function () {
    return response()->json([
        'status'   => 'ok',
        'message'  => 'Finance Backend running',
        'laravel'  => app()->version(),
        'api_base' => url('/api'),
        'endpoints' => [
            'POST /api/register',
            'POST /api/login',
            'POST /api/logout',
            'POST /api/change-password',
            'PUT  /api/user/profile',
            'GET  /api/transactions',
            'POST /api/transactions',
            'GET  /api/transactions/{id}',
            'PUT  /api/transactions/{id}',
            'DELETE /api/transactions/{id}',
        ],
    ]);
});
