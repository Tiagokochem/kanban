<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        return auth()->user()->boards()->with('categories.tasks')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        return auth()->user()->boards()->create($data);
    }

    public function show(Board $board)
    {
        $this->authorize('view', $board);

        return $board->load('categories.tasks');
    }

    public function update(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $board->update($data);

        return $board;
    }

    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);

        $board->delete();

        return response()->noContent();
    }
}
