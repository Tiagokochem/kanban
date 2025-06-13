<?php

use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Boards
    Route::apiResource('boards', BoardController::class);

    // Categories (precisa do board_id)
    Route::get('boards/{board}/categories', [CategoryController::class, 'index']);
    Route::post('boards/{board}/categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // Tasks (precisa da category_id)
    Route::get('categories/{category}/tasks', [TaskController::class, 'index']);
    Route::post('categories/{category}/tasks', [TaskController::class, 'store']);
    Route::put('tasks/{task}', [TaskController::class, 'update']);
    Route::delete('tasks/{task}', [TaskController::class, 'destroy']);

    // Endpoint para atualizar ordem e movimentação
    Route::post('tasks/{task}/move', [TaskController::class, 'move']);
});
