<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Board;
use App\Models\Category;

class AiChatController extends Controller
{
    /**
     * Process a chat message and interact with Groq API
     */
    public function processMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        
        try {
            // Call Groq API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.groq.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant that helps users create Kanban boards and tasks. Extract board title and tasks from user input. Format your response as JSON with "boardTitle" and "tasks" array with task titles and descriptions.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
                'response_format' => ['type' => 'json_object']
            ]);

            $aiResponse = $response->json();
            
            if (!isset($aiResponse['choices'][0]['message']['content'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to get proper response from AI'
                ], 500);
            }

            // Parse the AI response
            $content = json_decode($aiResponse['choices'][0]['message']['content'], true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to parse AI response'
                ], 500);
            }

            // Create the board and tasks if requested
            if ($request->input('create', false) && isset($content['boardTitle'])) {
                $board = $this->createBoardFromAiResponse($content);
                return response()->json([
                    'success' => true,
                    'message' => 'Board created successfully',
                    'aiResponse' => $content,
                    'board' => $board,
                    'redirectUrl' => route('boards.show', $board)
                ]);
            }

            return response()->json([
                'success' => true,
                'aiResponse' => $content
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing request: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a board and tasks from AI response
     */
    private function createBoardFromAiResponse($content)
    {
        // Create the board
        $board = Board::create([
            'title' => $content['boardTitle'] ?? 'New Board',
            'user_id' => Auth::id()
        ]);

        // Create default categories
        $todoCategory = $board->categories()->create([
            'name' => 'To Do',
            'order' => 1
        ]);

        $inProgressCategory = $board->categories()->create([
            'name' => 'In Progress',
            'order' => 2
        ]);

        $doneCategory = $board->categories()->create([
            'name' => 'Done',
            'order' => 3
        ]);

        // Add tasks to the "To Do" category
        if (isset($content['tasks']) && is_array($content['tasks'])) {
            foreach ($content['tasks'] as $index => $task) {
                $todoCategory->tasks()->create([
                    'title' => $task['title'] ?? 'Task ' . ($index + 1),
                    'description' => $task['description'] ?? '',
                    'order' => $index + 1
                ]);
            }
        }

        return $board;
    }
} 