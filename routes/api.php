<?php


use App\Http\Controllers\Api\BoardController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;

Route::middleware('auth:sanctum')->group(function () {

    // Boards → Se tiver
    Route::get('/boards/{board}/categories', [CategoryController::class, 'index']);
    Route::post('/boards/{board}/categories', [CategoryController::class, 'store']);

    // Categories
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::get('/categories/{category}/tasks', [CategoryController::class, 'tasks']);

    // Tasks
    Route::get('/categories/{category}/tasks', [TaskController::class, 'index']);
    Route::post('/categories/{category}/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
    Route::put('/tasks/{task}', [TaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
    Route::post('/tasks/{task}/move', [TaskController::class, 'move']);
});
