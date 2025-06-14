<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use AuthorizesRequests;
    
    public function index(Category $category)
    {
        $this->authorize('view', $category->board);

        return $category->tasks()->orderBy('order')->get();
    }

    public function store(Request $request, Category $category)
    {
        $this->authorize('update', $category->board);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        return $category->tasks()->create($data);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task->category->board);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $task->update($data);

        return $task;
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task->category->board);

        $task->delete();

        return response()->noContent();
    }

    public function move(Request $request, Task $task)
    {
        $this->authorize('update', $task->category->board);

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'order' => 'nullable|integer',
        ]);

        $task->update([
            'category_id' => $data['category_id'],
            'order' => $data['order'] ?? 0,
        ]);

        return $task;
    }
}
