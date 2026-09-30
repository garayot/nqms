<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(): View
    {
        $teams = Team::query()
            ->withCount([
                'teamLeads',
                'teamMembers',
                'teamSecretariat',
            ])
            ->orderBy('team_name')
            ->get();

        return view('admin.qms-teams.index', compact('teams'));
    }

    public function create(): View
    {
        return view('admin.qms-teams.create');
    }

    public function store(StoreTeamRequest $request): RedirectResponse
    {
        $team = Team::create($request->validated());

        return redirect()->route('admin.qms-teams.show', $team)->with('success', 'Team created successfully.');
    }

    public function show(Request $request, Team $team): View
    {
        $team->load([
            'teamLeads.user.position',
            'teamMembers.user.position',
            'teamSecretariat.user.position',
        ]);

        $isAdmin = (bool) $request->user()?->isAdmin();

        $availableLeadUsers = collect();
        $availableMemberUsers = collect();
        $availableSecretariatUsers = collect();

        if ($isAdmin) {
            $availableLeadUsers = User::query()
                ->with('position')
                ->whereDoesntHave('teamLeads', fn ($query) => $query->where('team_id', $team->id))
                ->orderBy('name')
                ->get();

            $availableMemberUsers = User::query()
                ->with('position')
                ->whereDoesntHave('teamMemberships', fn ($query) => $query->where('team_id', $team->id))
                ->orderBy('name')
                ->get();

            $availableSecretariatUsers = User::query()
                ->with('position')
                ->whereDoesntHave('teamSecretariats', fn ($query) => $query->where('team_id', $team->id))
                ->orderBy('name')
                ->get();
        }

        return view('admin.qms-teams.show', compact('team', 'availableLeadUsers', 'availableMemberUsers', 'availableSecretariatUsers', 'isAdmin'));
    }

    public function edit(Team $team): View
    {
        return view('admin.qms-teams.edit', compact('team'));
    }

    public function update(UpdateTeamRequest $request, Team $team): RedirectResponse
    {
        $team->update($request->validated());

        return redirect()->route('admin.qms-teams.show', $team)->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team): RedirectResponse
    {
        $teamName = $team->team_name;
        $team->delete();

        return redirect()->route('admin.qms-teams.index')->with('success', "{$teamName} deleted successfully.");
    }
}
