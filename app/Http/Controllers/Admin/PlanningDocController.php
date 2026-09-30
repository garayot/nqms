<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlanningDocRequest;
use App\Http\Requests\UpdatePlanningDocRequest;
use App\Models\FunctionalDiv;
use App\Models\PlanningDoc;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanningDocController extends Controller
{
    public function create(FunctionalDiv $functionalDiv): View
    {
        return view('admin.planning-docs.planning-docs.create', compact('functionalDiv'));
    }

    public function store(StorePlanningDocRequest $request, FunctionalDiv $functionalDiv): RedirectResponse
    {
        PlanningDoc::query()->create([
            ...$request->validated(),
            'functional_div_id' => $functionalDiv->id,
        ]);

        return redirect()->route('admin.planning-docs.index')->with('success', 'Planning document created.');
    }

    public function edit(FunctionalDiv $functionalDiv, PlanningDoc $planningDoc): View
    {
        $this->ensureBelongsToDivision($functionalDiv, $planningDoc);

        return view('admin.planning-docs.planning-docs.edit', compact('functionalDiv', 'planningDoc'));
    }

    public function update(UpdatePlanningDocRequest $request, FunctionalDiv $functionalDiv, PlanningDoc $planningDoc): RedirectResponse
    {
        $this->ensureBelongsToDivision($functionalDiv, $planningDoc);

        $planningDoc->update([
            ...$request->validated(),
            'functional_div_id' => $functionalDiv->id,
        ]);

        return redirect()->route('admin.planning-docs.index')->with('success', 'Planning document updated.');
    }

    public function destroy(FunctionalDiv $functionalDiv, PlanningDoc $planningDoc): RedirectResponse
    {
        $this->ensureBelongsToDivision($functionalDiv, $planningDoc);

        $planningDoc->delete();

        return redirect()->route('admin.planning-docs.index')->with('success', 'Planning document deleted.');
    }

    private function ensureBelongsToDivision(FunctionalDiv $functionalDiv, PlanningDoc $planningDoc): void
    {
        if ($planningDoc->functional_div_id !== $functionalDiv->id) {
            abort(404);
        }
    }
}
