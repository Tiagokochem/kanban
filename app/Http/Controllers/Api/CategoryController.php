<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Board $board)
    {
        $this->authorize('view', $board);

        return $board->categories()->with('tasks')->orderBy('order')->get();
    }

    public function store(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        return $board->categories()->create($data);
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category->board);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        $category->update($data);

        return $category;
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category->board);

        $category->delete();

        return response()->noContent();
    }
}
