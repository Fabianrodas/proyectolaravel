<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\FollowController;

Route::redirect('/', '/login');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Home
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

// Posts (solo accesibles si estás logueado)
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::resource('posts', PostController::class)->only(['index', 'show']);
Route::get('/profile', [UserController::class, 'showProfile'])->middleware('auth')->name('profile');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/user/{id}', [UserController::class, 'show'])->name('users.profile');
Route::post('/follow/{id}', [FollowController::class, 'toggleFollow'])->name('follow.toggle');

Route::get('/settings', [UserController::class, 'edit'])->name('settings');
Route::post('/settings', [UserController::class, 'update']);
Route::post('/settings/delete', [UserController::class, 'destroy'])->name('account.delete');
