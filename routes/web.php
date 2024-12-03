<?php

use App\Http\Controllers\ConversationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/{id}/conversation', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/messages', [ConversationController::class, 'store'])->name('messages.store');
});
