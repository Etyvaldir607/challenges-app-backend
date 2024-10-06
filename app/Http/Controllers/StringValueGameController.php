<?php

namespace App\Http\Controllers;

use App\Models\StringValueGame;
use App\Services\StringValueGameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StringValueGameController extends Controller
{
    protected $stringValueGameService;

    public function __construct(StringValueGameService $stringValueGameService)
    {
        $this->stringValueGameService = $stringValueGameService;
    }

    public function maxValue(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'string_value' => 'required|string',
        ]);
        // Resolve game
        $result = $this->stringValueGameService->maxValue(
            $validated['string_value'],
        );
        try {
            $validated = $request->validate([
                'string_value' => 'required|string',
            ]);

            // Resolve game
            $result = $this->stringValueGameService->maxValue(
                $validated['string_value'],
            );

            // Save game in database
            $game = StringValueGame::create([
                "string_value" => $validated['string_value'],
                "result" => $result
            ]);

            return $this->sendResponse(
                ['result' => $result],
                'Game attempt success',
                200
            );
        } catch (\Exception $e) {
            $status_code = is_integer($e->getCode()) ? $e->getCode() : 500;
            return $this->sendError("Game attempt failed" ,$e->getMessage() , $status_code);
        }
    }
}
