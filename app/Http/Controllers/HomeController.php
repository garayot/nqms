<?php

namespace App\Http\Controllers;

use App\Models\ProcessGroup;

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

    public function organization()
    {
        return view('pages.organization');
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
}
