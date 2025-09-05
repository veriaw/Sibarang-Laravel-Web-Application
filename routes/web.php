<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('auth/login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('auth/register');
});
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/logout', [AuthController::class, 'logout']);
