<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamLeadRequest;
use App\Models\Team;
use App\Models\TeamLead;
use Illuminate\Http\RedirectResponse;

class TeamLeadController extends Controller
{
    public function store(StoreTeamLeadRequest $request, Team $team): RedirectResponse
    {
        $team->teamLeads()->firstOrCreate([
            'user_id' => $request->integer('user_id'),
        ]);

        return back()->with('success', 'Team lead added.');
    }

    public function destroy(Team $team, TeamLead $teamLead): RedirectResponse
    {
        abort_if($teamLead->team_id !== $team->id, 404);

        $teamLead->delete();

        return back()->with('success', 'Team lead removed.');
    }
}
