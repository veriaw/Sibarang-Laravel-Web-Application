<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
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

Route::get('/loan', [LoanController::class, 'index'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::post('/updateprofile/{id}', [ProfileController::class, 'updateProfile'])->name('profile.update');

// inventory route
Route::post('/addbarang', [DashboardController::class, 'addBarang'])->name('inventories.add');

Route::post('/updatebarang/{id}', [DashboardController::class, 'updateBarang'])->name('inventories.update');

Route::post('/deletebarang/{id}', [DashboardController::class, 'deleteBarang'])->name('inventories.delete');

// loan route
Route::post('/addloan', [LoanController::class, 'addLoan'])->name('loan.add');
Route::post('/updateloan/{id}', [LoanController::class, 'updateLoan'])->name('loan.update');
Route::post('/deleteloan/{id}', [LoanController::class, 'deleteLoan'])->name('loan.delete');
Route::get('/loanprint/{id}', [LoanController::class, 'exportPDF'])->name('loan.print');

Route::get('/logout', [AuthController::class, 'logout']);
