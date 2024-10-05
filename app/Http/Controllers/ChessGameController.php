<?php

namespace App\Http\Controllers;

use App\Models\ChessGame;
use App\Services\ChessGameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChessGameController extends Controller
{
    protected $chessGameService;

    public function __construct(ChessGameService $chessGameService)
    {
        $this->chessGameService = $chessGameService;
    }

    public function queensAttack(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'board_size' => 'required|integer',
                'total_obstacles' => 'required|integer',
                'queen_rows' => 'required|integer',
                'queen_columns' => 'required|integer',
                'obstacles' => 'required|array',
                'obstacles.*' => 'array|min:2|max:2',
                'obstacles.*.*' => 'required|integer'
            ]);

            // Resolve game
            $result = $this->chessGameService->queensAttack(
                $validated['board_size'],
                $validated['total_obstacles'],
                $validated['queen_rows'],
                $validated['queen_columns'],
                $validated['obstacles'],
            );

            // Save game in database
            $game = ChessGame::create([
                "board_size" => $validated['board_size'],
                "total_obstacles"=> $validated['total_obstacles'],
                "queen_rows"=> $validated['queen_rows'],
                "queen_columns"=> $validated['queen_columns'],
                "obstacles"=> json_encode($validated['obstacles']),
                "attacks" => $result
            ]);

            return $this->sendResponse(
                ['attacks' => $result],
                'Game attempt success',
                200
            );
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return $this->sendError("Game attempt failed" ,$e->getMessage() , $status_code);
        }
    }
}
