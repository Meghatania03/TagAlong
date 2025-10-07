<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('login');
})->name('login');
Route::get('/signup', [UsersController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [UsersController::class, 'store'])->name('signup.submit');
