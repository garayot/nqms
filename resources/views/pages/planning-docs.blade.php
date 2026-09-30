@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-4xl font-bold text-[#0f3d68]">Planning Documents</h1>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="flex-1">
                    <label for="planning-docs-search" class="sr-only">Search Planning Documents</label>
                    <input id="planning-docs-search" type="text" placeholder="Type keyword to search Functional Division or Planning Document..." class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <button type="button" id="planning-docs-clear" class="rounded-lg border border-slate-300 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Clear</button>
            </div>
        </div>

        <div class="mt-6 space-y-4" id="planning-docs-container">
            @forelse ($functionalDivs as $functionalDiv)
                <section class="planning-division overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" data-search="{{ strtolower($functionalDiv->name.' '.$functionalDiv->url) }}" data-expanded="false">
                    <h2>
                        <button type="button" class="planning-toggle flex w-full items-center justify-between gap-3 border-b border-slate-200 bg-blue-50 px-4 py-4 text-left text-lg font-semibold text-[#0f3d68] transition-colors hover:bg-blue-100" aria-expanded="false" aria-controls="planning-division-panel-{{ $functionalDiv->id }}" id="planning-division-trigger-{{ $functionalDiv->id }}">
                            <span>{{ $functionalDiv->name }}</span>
                            <svg data-accordion-icon class="planning-icon h-5 w-5 shrink-0 text-[#0f3d68] transition-transform duration-200 ease-out" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7" />
                            </svg>
                        </button>
                    </h2>

                    <div id="planning-division-panel-{{ $functionalDiv->id }}" role="region" aria-labelledby="planning-division-trigger-{{ $functionalDiv->id }}" class="planning-panel grid grid-rows-[0fr] overflow-hidden transition-all duration-300 ease-in-out opacity-0">
                        <div class="space-y-3 overflow-hidden p-4">
                            @if ($functionalDiv->url)
                                <div>
                                    <a href="{{ $functionalDiv->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-md bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200">Open Division Folder</a>
                                </div>
                            @endif

                            <div class="space-y-2">
                                @forelse ($functionalDiv->planningDocs as $planningDoc)
                                    <div class="planning-document overflow-hidden rounded-lg border border-slate-200" data-search="{{ strtolower($planningDoc->name.' '.$planningDoc->url) }}">
                                        <div class="flex flex-col gap-3 bg-white px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="text-sm font-medium text-slate-800">{{ $planningDoc->name }}</div>
                                            <div>
                                                <a href="{{ $planningDoc->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-md bg-[#0f3d68] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#0b2f52]">Open</a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-lg border border-dashed border-slate-300 px-4 py-3 text-sm text-slate-500">No planning documents have been added for this functional division.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-slate-500 shadow-sm">No planning documents available.</div>
            @endforelse
        </div>
    </div>

    <script>
        (() => {
            const searchInput = document.getElementById('planning-docs-search');
            const clearButton = document.getElementById('planning-docs-clear');
            const divisions = document.querySelectorAll('#planning-docs-container > .planning-division');

            if (!searchInput || !clearButton || divisions.length === 0) {
                return;
            }

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

            const applyFilter = () => {
                const term = searchInput.value.trim().toLowerCase();

                divisions.forEach((division) => {
                    const divisionText = division.dataset.search || '';
                    const documents = division.querySelectorAll(':scope > .planning-panel .planning-document[data-search]');
                    let divisionVisible = false;

                    documents.forEach((documentItem) => {
                        const documentText = documentItem.dataset.search || '';
                        const showDocument = term === '' || documentText.includes(term);

                        documentItem.style.display = showDocument ? '' : 'none';
                        divisionVisible = divisionVisible || showDocument;
                    });

                    if (term !== '' && divisionText.includes(term)) {
                        divisionVisible = true;
                        documents.forEach((documentItem) => {
                            documentItem.style.display = '';
                        });
                    }

                    division.style.display = divisionVisible ? '' : 'none';
                    syncAccordion(division, divisionVisible);
                });
            };

            searchInput.addEventListener('input', applyFilter);
            clearButton.addEventListener('click', () => {
                searchInput.value = '';
                applyFilter();
                searchInput.focus();
            });
        })();
    </script>
@endsection