<?php

namespace App\Http\Controllers;

use App\Enums\QmsOrganizationRole;
use App\Models\FunctionalDiv;
use App\Models\ProcessGroup;
use App\Models\QmsOrganizationMember;
use App\Models\Team;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function links()
    {
        return view('pages.links');
    }

    public function qps()
    {
        return view('pages.qps');
    }

    public function organization()
    {
        $roleOrder = [
            QmsOrganizationRole::SDS->value => 1,
            QmsOrganizationRole::ASDS->value => 2,
            QmsOrganizationRole::QMR->value => 3,
            QmsOrganizationRole::SECRETARIAT_TEAM_LEAD->value => 4,
            QmsOrganizationRole::SECRETARIAT_TEAM_MEMBER->value => 5,
        ];

        $members = QmsOrganizationMember::query()
            ->with('user.position')
            ->get()
            ->sortBy(fn (QmsOrganizationMember $member): array => [
                $roleOrder[$member->role->value] ?? 99,
                $member->display_order,
                $member->id,
            ])
            ->values();

        $membersByRole = $members->groupBy(fn (QmsOrganizationMember $member): string => $member->role->value);

        return view('pages.qms-organization', compact('membersByRole'));
    }

    public function teams()
    {
        $teams = Team::query()
            ->withCount([
                'teamLeads',
                'teamMembers',
                'teamSecretariat',
            ])
            ->orderBy('team_name')
            ->get();

        return view('pages.organization', compact('teams'));
    }

    public function operationsManual()
    {
        $processGroups = ProcessGroup::query()
            ->with([
                'processes' => fn ($query) => $query->orderBy('id')->with([
                    'subProcesses' => fn ($subQuery) => $subQuery->orderBy('id'),
                ]),
            ])
            ->orderBy('id')
            ->get();

        return view('pages.operations-manual', compact('processGroups'));
    }

    public function planningDocs()
    {
        $functionalDivs = FunctionalDiv::query()
            ->with([
                'planningDocs' => fn ($query) => $query->orderBy('name'),
            ])
            ->orderBy('name')
            ->get();

        return view('pages.planning-docs', compact('functionalDivs'));
    }
}
