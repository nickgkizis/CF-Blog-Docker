<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Auth;

// Main page with links to user management, registration, login, and article creation
Route::get('/', function () {
    return view('main');  // This will be the new main page view
});


//(no middleware, public access)
// Registration 
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
// Login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
// Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
// Articles
Route::resource('articles', ArticleController::class);

// Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/user/search', [ArticleController::class, 'searchByUser'])->name('articles.searchByUser');
Route::get('/articles/article/search', [ArticleController::class, 'searchByArticle'])->name('articles.searchByArticle');
Route::get('/articles/article/sort', [ArticleController::class, 'sortByDate'])->name('articles.sort');






//(protected by auth middleware)
// Article Routes 
Route::middleware('auth')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});
// User management routes 
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});