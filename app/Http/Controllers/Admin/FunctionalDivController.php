<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFunctionalDivRequest;
use App\Http\Requests\UpdateFunctionalDivRequest;
use App\Models\FunctionalDiv;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FunctionalDivController extends Controller
{
    public function index(): View
    {
        $functionalDivs = FunctionalDiv::query()
            ->with(['planningDocs' => fn ($query) => $query->orderBy('name')])
            ->withCount('planningDocs')
            ->orderBy('name')
            ->get();

        return view('admin.planning-docs.index', compact('functionalDivs'));
    }

    public function create(): View
    {
        return view('admin.planning-docs.functional-divisions.create');
    }

    public function store(StoreFunctionalDivRequest $request): RedirectResponse
    {
        FunctionalDiv::query()->create($request->validated());

        return redirect()->route('admin.planning-docs.index')->with('success', 'Functional division created.');
    }

    public function edit(FunctionalDiv $functionalDiv): View
    {
        return view('admin.planning-docs.functional-divisions.edit', compact('functionalDiv'));
    }

    public function update(UpdateFunctionalDivRequest $request, FunctionalDiv $functionalDiv): RedirectResponse
    {
        $functionalDiv->update($request->validated());

        return redirect()->route('admin.planning-docs.index')->with('success', 'Functional division updated.');
    }

    public function destroy(FunctionalDiv $functionalDiv): RedirectResponse
    {
        $planningDocsCount = $functionalDiv->planningDocs()->count();

        $functionalDiv->delete();

        $message = $planningDocsCount > 0
            ? "Functional division deleted. {$planningDocsCount} related planning document(s) were also deleted."
            : 'Functional division deleted.';

        return redirect()->route('admin.planning-docs.index')->with('success', $message);
    }
}
