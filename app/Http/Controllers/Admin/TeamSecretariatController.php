<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamSecretariatRequest;
use App\Models\Team;
use App\Models\TeamSecretariat;
use Illuminate\Http\RedirectResponse;

class TeamSecretariatController extends Controller
{
    public function store(StoreTeamSecretariatRequest $request, Team $team): RedirectResponse
    {
        $team->teamSecretariat()->firstOrCreate([
            'user_id' => $request->integer('user_id'),
        ]);

        return back()->with('success', 'Team secretariat added.');
    }

    public function destroy(Team $team, TeamSecretariat $teamSecretariat): RedirectResponse
    {
        abort_if($teamSecretariat->team_id !== $team->id, 404);

        $teamSecretariat->delete();

        return back()->with('success', 'Team secretariat removed.');
    }
}
