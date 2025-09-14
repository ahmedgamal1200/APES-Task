<?php

namespace Modules\Teams\Http\Controllers\Api\V1\Teams;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Exception;
use Modules\Teams\Http\Requests\StoreGenerateSlotsRequest;
use Modules\Teams\Models\Team;
use Modules\Teams\Services\SlotGeneratorService;

class GenerateSlotController extends Controller
{
    public function generateSlots(StoreGenerateSlotsRequest $request, Team $team, SlotGeneratorService $slotGeneratorService): JsonResponse
    {
        try {
            if ($team->availability->isEmpty()) {
                return response()->json(['message' => 'Team has no availability set.'], 404);
            }

            $bookings = $team->bookings()->whereBetween('start_time', [
                Carbon::parse($request->from)->startOfDay(),
                Carbon::parse($request->to)->endOfDay()
            ])->get();

            $slots = $slotGeneratorService->generate(
                $team->availability,
                $bookings,
                Carbon::parse($request->from),
                Carbon::parse($request->to)
            );

            return response()->json(['slots' => $slots]);

        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while generating slots.'], 500);
        }
    }
}
