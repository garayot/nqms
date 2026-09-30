<?php

namespace App\Http\Controllers;

use App\Models\FunctionalDiv;
use App\Models\ProcessGroup;
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
