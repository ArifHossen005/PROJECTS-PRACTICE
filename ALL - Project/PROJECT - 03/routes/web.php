<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Signup Routes
Route::get('/signup', [AuthController::class, 'signupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');



Route::middleware('auth')->group(function () {


    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Management
    Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/change-password', [AuthController::class, 'changePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.update-password');


    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');


    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/authors/{id}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::put('/authors/{id}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');


    Route::resource('books', BookController::class);
});
