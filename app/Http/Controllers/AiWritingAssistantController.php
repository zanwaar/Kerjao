<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImproveWritingRequest;
use App\Services\AiWritingAssistantService;
use Illuminate\Http\JsonResponse;

class AiWritingAssistantController extends Controller
{
    public function __construct(private AiWritingAssistantService $aiWritingAssistantService) {}

    public function improve(ImproveWritingRequest $request): JsonResponse
    {
        $result = $this->aiWritingAssistantService->improve(
            $request->string('context')->toString(),
            $request->string('text')->toString(),
        );

        if (! $result['ok']) {
            return response()->json($result, 422);
        }

        return response()->json($result);
    }
}
