<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;

Route::redirect('/', '/login');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home (protected)
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');


Route::resource('posts', PostController::class);
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');