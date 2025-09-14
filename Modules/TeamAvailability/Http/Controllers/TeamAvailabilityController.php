<?php

namespace Modules\TeamAvailability\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\TeamAvailability\Http\Requests\StoreTeamAvailabilityRequest;
use Modules\TeamAvailability\Models\TeamAvailability;
use Modules\Teams\Models\Team;

class TeamAvailabilityController extends Controller
{
    public function store(StoreTeamAvailabilityRequest $request, Team $team)
    {
        if ($team->tenant_id !== auth()->user()->tenant_id) {
            return response()->json(['message' => 'Unauthorized action.'], 403);
        }

        $validatedData = $request->validated();
        // Convert day_of_week to integer (0 for Sunday, 6 for Saturday)

        $validatedData['day_of_week'] = array_search(strtolower($validatedData['day_of_week']), ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);

        $teamAvailability = TeamAvailability::query()->create($validatedData);

        return response()->json(['message' => 'Team availability created successfully', 'data' => $teamAvailability], 201);
    }


}
