<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardApiController extends Controller
{
    public function categories(Board $board)
    {
        if (auth()->id() !== $board->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(
            $board->categories()->orderBy('order')->get()
        );
    }
}
