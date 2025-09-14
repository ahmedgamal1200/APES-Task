<?php

namespace Modules\Teams\Http\Controllers\Api\V1\Teams;

use App\Http\Controllers\Controller;
use Modules\Teams\Http\Requests\StoreTeamRequest;
use Modules\Teams\Models\Team;

class TeamsController extends Controller
{

    public function index()
    {
        $teams = Team::query()->get();

        return response()->json(['teams' => $teams], 200);
    }
    public function store(StoreTeamRequest $request)
    {
        $team = Team::query()->create(
            array_merge($request->validated(), [
                'tenant_id' => auth()->user()->tenant_id,
            ])
        );

        return response()->json(['message' => 'Team created successfully', 'team' => $team], 201);
    }
}


