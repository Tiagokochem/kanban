<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    use AuthorizesRequests;

    /**
     * Listar todas as categorias de um board, já trazendo as tasks.
     */
    public function index(Board $board)
    {
        $this->authorize('view', $board);

        return $board->categories()
            ->with('tasks')
            ->orderBy('order')
            ->get();
    }

    /**
     * Criar uma nova categoria (coluna) no board.
     */
    public function store(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer',
        ]);

        return $board->categories()->create($data);
    }

    /**
     * Atualizar uma categoria (coluna).
     */
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

    /**
     * Deletar uma categoria (coluna).
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category->board);

        $category->delete();

        return response()->noContent();
    }

    /**
     * Listar tasks de uma categoria específica.
     */
    public function tasks(Category $category)
    {
        $this->authorize('view', $category->board);

        return $category->tasks()->orderBy('order')->get();
    }
}
