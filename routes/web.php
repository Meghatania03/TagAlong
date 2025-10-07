<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('login');
})->name('login');
Route::get('/signup', [UsersController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [UsersController::class, 'store'])->name('signup.submit');
//login route is defined in the login.blade.php file form action attribute


// Show login page
Route::get('/login', [UsersController::class, 'showLoginForm'])->name('login');

// Handle login form submission
Route::post('/login', [UsersController::class, 'login'])->name('login.submit');

// Protected page after login (example dashboard)
Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('dashboard')->middleware('auth');
