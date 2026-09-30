<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamMemberRequest;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;

class TeamMemberController extends Controller
{
    public function store(StoreTeamMemberRequest $request, Team $team): RedirectResponse
    {
        $team->teamMembers()->firstOrCreate([
            'user_id' => $request->integer('user_id'),
        ]);

        return back()->with('success', 'Team member added.');
    }

    public function destroy(Team $team, TeamMember $teamMember): RedirectResponse
    {
        abort_if($teamMember->team_id !== $team->id, 404);

        $teamMember->delete();

        return back()->with('success', 'Team member removed.');
    }
}
