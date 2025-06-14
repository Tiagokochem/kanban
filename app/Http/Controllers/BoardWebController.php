<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardWebController extends Controller
{
    public function index()
    {
        $boards = Auth::user()->boards()->get();
        return view('dashboard', compact('boards'));
    }

    public function show(Board $board)
    {
        if (Auth::user()->id !== $board->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('boards.show', compact('board'));
    }

    public function create()
    {
        return view('boards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $board = Auth::user()->boards()->create($validated);

        return redirect()->route('boards.show', $board)->with('success', 'Quadro criado com sucesso!');
    }

    public function storeCategory(Request $request, Board $board)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $board->categories()->create([
            'name' => $request->name,
            'order' => $board->categories()->max('order') + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Categoria criada com sucesso!',
        ]);
    }

    public function storeTask(Request $request, \App\Models\Category $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $category->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $category->tasks()->max('order') + 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tarefa criada com sucesso!',
        ]);
    }
}
