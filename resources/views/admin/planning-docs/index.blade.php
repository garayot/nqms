@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Planning Documents</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage functional divisions and their planning document links.</p>
                </div>
                <a href="{{ route('admin.planning-docs.functional-divisions.create') }}" class="inline-flex items-center rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">+ Add Functional Division</a>
            </div>
        </div>

        <div class="space-y-4" id="planning-docs-container">
            @forelse ($functionalDivs as $functionalDiv)
                <section class="planning-division overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" data-expanded="false">
                    <h2>
                        <button type="button" class="planning-toggle flex w-full items-center justify-between gap-3 border-b border-slate-200 bg-blue-50 px-4 py-4 text-left text-lg font-semibold text-[#0f3d68] transition-colors hover:bg-blue-100" aria-expanded="false" aria-controls="planning-division-panel-{{ $functionalDiv->id }}" id="planning-division-trigger-{{ $functionalDiv->id }}">
                            <span>{{ $functionalDiv->name }}</span>
                            <svg data-accordion-icon class="planning-icon h-5 w-5 shrink-0 text-[#0f3d68] transition-transform duration-200 ease-out" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 9 7 7 7-7" />
                            </svg>
                        </button>
                    </h2>

                    <div id="planning-division-panel-{{ $functionalDiv->id }}" role="region" aria-labelledby="planning-division-trigger-{{ $functionalDiv->id }}" class="planning-panel grid grid-rows-[0fr] overflow-hidden transition-all duration-300 ease-in-out opacity-0">
                        <div class="space-y-3 overflow-hidden p-4">
                            <div class="flex flex-wrap items-center gap-2">
                                @if ($functionalDiv->url)
                                    <a href="{{ $functionalDiv->url }}" target="_blank" rel="noopener noreferrer" class="rounded-md bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200">Open Division Folder</a>
                                @endif

                                <a href="{{ route('admin.planning-docs.documents.create', $functionalDiv) }}" class="rounded-md bg-[#0f3d68] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#0b2f52]">+ Add Planning Document</a>
                                <a href="{{ route('admin.planning-docs.functional-divisions.edit', $functionalDiv) }}" class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">Edit</a>
                                <form method="POST" action="{{ route('admin.planning-docs.functional-divisions.destroy', $functionalDiv) }}" onsubmit="return confirm('Are you sure you want to delete {{ addslashes($functionalDiv->name) }}? This Functional Division has {{ $functionalDiv->planning_docs_count }} Planning Document(s). Deleting it will also remove its associated Planning Documents.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Delete</button>
                                </form>
                            </div>

                            <div class="space-y-2">
                                @forelse ($functionalDiv->planningDocs as $planningDoc)
                                    <div class="overflow-hidden rounded-lg border border-slate-200">
                                        <div class="flex flex-col gap-3 bg-white px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="text-sm font-medium text-slate-800">{{ $planningDoc->name }}</div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <a href="{{ $planningDoc->url }}" target="_blank" rel="noopener noreferrer" class="rounded-md bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200">Open</a>
                                                <a href="{{ route('admin.planning-docs.documents.edit', [$functionalDiv, $planningDoc]) }}" class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">Edit</a>
                                                <form method="POST" action="{{ route('admin.planning-docs.documents.destroy', [$functionalDiv, $planningDoc]) }}" onsubmit="return confirm('Delete this planning document?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-lg border border-dashed border-slate-300 px-4 py-3 text-sm text-slate-500">
                                        No planning documents have been added for this functional division.
                                        <a href="{{ route('admin.planning-docs.documents.create', $functionalDiv) }}" class="ml-2 font-semibold text-[#0f3d68] hover:text-[#0b2f52]">+ Add Planning Document</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-slate-500 shadow-sm">
                    No Functional Divisions have been added yet.
                    <div class="mt-4">
                        <a href="{{ route('admin.planning-docs.functional-divisions.create') }}" class="inline-flex items-center rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">+ Add Functional Division</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        (() => {
            const syncAccordion = (accordion, expanded) => {
                const panel = accordion.querySelector(':scope > .planning-panel');
                const trigger = accordion.querySelector(':scope > h2 > .planning-toggle');
                const icon = accordion.querySelector(':scope > h2 .planning-icon');

                if (!panel || !trigger) {
                    return;
                }

                accordion.dataset.expanded = expanded ? 'true' : 'false';
                trigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                panel.classList.toggle('grid-rows-[1fr]', expanded);
                panel.classList.toggle('grid-rows-[0fr]', !expanded);
                panel.classList.toggle('opacity-100', expanded);
                panel.classList.toggle('opacity-0', !expanded);

                if (icon) {
                    icon.classList.toggle('rotate-180', expanded);
                }
            };

            const accordionButtons = document.querySelectorAll('#planning-docs-container .planning-toggle');

            accordionButtons.forEach((button) => {
                const accordion = button.closest('.planning-division');

                if (!accordion) {
                    return;
                }

                syncAccordion(accordion, accordion.dataset.expanded !== 'false');

                button.addEventListener('click', () => {
                    const nextExpanded = accordion.dataset.expanded !== 'false' ? false : true;

                    syncAccordion(accordion, nextExpanded);
                });
            });
        })();
    </script>
@endsection