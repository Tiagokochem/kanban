<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BoardWebController;
use App\Http\Controllers\AiChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// 🔥 Remove a rota antiga do dashboard que causava conflito!

Route::middleware('auth')->group(function () {
    // Dashboard - Lista de Boards
    Route::get('/dashboard', [BoardWebController::class, 'index'])->name('dashboard');

    // Boards
    Route::get('/boards/create', [BoardWebController::class, 'create'])->name('boards.create');
    Route::post('/boards', [BoardWebController::class, 'store'])->name('boards.store');
    Route::get('/boards/{board}', [BoardWebController::class, 'show'])->name('boards.show');
    Route::get('/boards/{board}/edit', [BoardWebController::class, 'edit'])->name('boards.edit');
    Route::put('/boards/{board}', [BoardWebController::class, 'update'])->name('boards.update');
    Route::delete('/boards/{board}', [BoardWebController::class, 'destroy'])->name('boards.destroy');
    Route::post('/boards/{board}/categories', [BoardWebController::class, 'storeCategory'])->name('categories.store');
    Route::post('/categories/{category}/tasks', [BoardWebController::class, 'storeTask'])->name('tasks.store');

    // AI Chat
    Route::post('/ai-chat/message', [AiChatController::class, 'processMessage'])->name('ai-chat.message');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth gerado pelo Breeze
require __DIR__.'/auth.php';
