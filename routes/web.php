<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;

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
//Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('dashboard')->middleware('auth');

//navbar routes
Route::middleware(['checkUser'])->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.my');
    Route::get('/interested', [EventController::class, 'interested'])->name('events.interested');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

    Route::post('/events/{event}/toggle-interest', [EventController::class, 'toggleInterest'])->name('events.toggleInterest');


    Route::post('/logout', [UsersController::class, 'logout'])->name('logout');
});

// Show create event form
Route::get('/my-events/create', [EventController::class, 'create'])->name('events.create');

// Handle  create event form submission
Route::post('/my-events', [EventController::class, 'store'])->name('events.store');

//show user profile
Route::get('/users/{id}', [UsersController::class, 'show_profile'])->name('users.show_profile');

//delete events
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');




