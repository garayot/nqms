@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-4xl font-bold text-[#0f3d68]">Operations Manual</h1>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="flex-1">
                    <label for="operations-manual-search" class="sr-only">Search Operations Manual</label>
                    <input id="operations-manual-search" type="text" placeholder="Type keyword to search Process Group, Process, or Sub-Process..." class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-[#0f3d68] focus:outline-none">
                </div>
                <button type="button" id="operations-manual-clear" class="rounded-lg border border-slate-300 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Clear</button>
            </div>
        </div>

        <div class="mt-6 space-y-4" id="operations-manual-container">
            @forelse ($processGroups as $processGroup)
                <section class="operations-group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" data-search="{{ strtolower($processGroup->process_group_name) }}" data-expanded="false">
                    <h2>
                        <button type="button" class="operations-toggle flex w-full items-center justify-between gap-3 border-b border-slate-200 bg-blue-50 px-4 py-4 text-left text-lg font-semibold text-[#0f3d68] transition-colors hover:bg-blue-100" aria-expanded="false" aria-controls="operations-group-panel-{{ $processGroup->id }}" id="operations-group-trigger-{{ $processGroup->id }}">
                            <span class="flex-1">Process Group: {{ $processGroup->process_group_name }}</span>

                            <div class="flex items-center gap-2">
                                @if ($processGroup->url)
                                    <a href="{{ $processGroup->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-md bg-[#0f3d68] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#0b2f52]">Open Process Group Link</a>
                                @else
                                    <span class="inline-flex rounded-md bg-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">No Link</span>
                                @endif
                            </div>

                            <svg data-accordion-icon class="operations-icon h-5 w-5 shrink-0 text-[#0f3d68] transition-transform duration-200 ease-out" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7" />
                            </svg>
                        </button>
                    </h2>

                    <div id="operations-group-panel-{{ $processGroup->id }}" role="region" aria-labelledby="operations-group-trigger-{{ $processGroup->id }}" class="operations-panel grid grid-rows-[0fr] overflow-hidden transition-all duration-300 ease-in-out opacity-0">
                        <div class="overflow-hidden p-4">
                            
                        @forelse ($processGroup->processes as $process)
                            <section class="operations-process overflow-hidden rounded-xl border border-slate-200" data-search="{{ strtolower($process->process_name) }}" data-expanded="false">
                                <h3>
                                    <button type="button" class="operations-toggle flex w-full items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-4 py-3 text-left text-base font-semibold text-slate-800 transition-colors hover:bg-slate-100" aria-expanded="false" aria-controls="operations-process-panel-{{ $process->id }}" id="operations-process-trigger-{{ $process->id }}">
                                        <span>Process: {{ $process->process_name }}</span>
                                        <svg data-accordion-icon class="operations-icon h-5 w-5 shrink-0 text-slate-600 transition-transform duration-200 ease-out" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 15 7-7 7 7" />
                                        </svg>
                                    </button>
                                </h3>

                                <div id="operations-process-panel-{{ $process->id }}" role="region" aria-labelledby="operations-process-trigger-{{ $process->id }}" class="operations-panel grid grid-rows-[0fr] overflow-hidden transition-all duration-300 ease-in-out opacity-0">
                                    <div class="overflow-hidden p-3">
                                    @forelse ($process->subProcesses as $subProcess)
                                        <div class="operations-subprocess overflow-hidden rounded-lg border border-slate-200" data-search="{{ strtolower($subProcess->sub_process_name.' '.$subProcess->url) }}">
                                            <div class="flex flex-col gap-3 bg-white px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                                                <div class="text-sm font-medium text-slate-800">Sub-Process: {{ $subProcess->sub_process_name }}</div>
                                                <div>
                                                    @if ($subProcess->url)
                                                        <a href="{{ $subProcess->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex rounded-md bg-[#0f3d68] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#0b2f52]">Open QCP</a>
                                                    @else
                                                        <span class="inline-flex rounded-md bg-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">No QCP Link</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="rounded-lg border border-dashed border-slate-300 px-4 py-3 text-sm text-slate-500">No sub-processes available for this process.</div>
                                    @endforelse
                                    </div>
                                </div>
                            </section>
                        @empty
                            <div class="rounded-lg border border-dashed border-slate-300 px-4 py-3 text-sm text-slate-500">No processes available for this process group.</div>
                        @endforelse
                        </div>
                    </div>
                </section>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-slate-500 shadow-sm">No operations manual records available.</div>
            @endforelse
        </div>
    </div>

    <script>
        (() => {
            const searchInput = document.getElementById('operations-manual-search');
            const clearButton = document.getElementById('operations-manual-clear');
            const groups = document.querySelectorAll('#operations-manual-container > .operations-group');

            if (!searchInput || !clearButton || groups.length === 0) {
                return;
            }

            const syncAccordion = (accordion, expanded) => {
                const panel = accordion.querySelector(':scope > .operations-panel');
                const trigger = accordion.querySelector(':scope > h2 > .operations-toggle, :scope > h3 > .operations-toggle');
                const icon = accordion.querySelector(':scope > h2 .operations-icon, :scope > h3 .operations-icon');

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

            const accordionButtons = document.querySelectorAll('#operations-manual-container .operations-toggle');

            accordionButtons.forEach((button) => {
                const accordion = button.closest('.operations-group, .operations-process');

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

                groups.forEach((group) => {
                    let groupVisible = false;

                    const groupText = group.dataset.search || '';
                    const processes = group.querySelectorAll(':scope > .operations-panel > div > .operations-process');

                    processes.forEach((process) => {
                        let processVisible = false;
                        const processText = process.dataset.search || '';
                        const subProcesses = process.querySelectorAll(':scope > .operations-panel .operations-subprocess[data-search]');

                        subProcesses.forEach((subProcess) => {
                            const subText = subProcess.dataset.search || '';
                            const showSub = term === '' || subText.includes(term);
                            subProcess.style.display = showSub ? '' : 'none';
                            processVisible = processVisible || showSub;
                        });

                        if (term !== '' && processText.includes(term)) {
                            processVisible = true;
                            subProcesses.forEach((subProcess) => {
                                subProcess.style.display = '';
                            });
                        }

                        process.style.display = processVisible ? '' : 'none';
                        syncAccordion(process, processVisible);
                        groupVisible = groupVisible || processVisible;
                    });

                    if (term !== '' && groupText.includes(term)) {
                        groupVisible = true;
                        processes.forEach((process) => {
                            process.style.display = '';
                            syncAccordion(process, true);
                            const subProcesses = process.querySelectorAll(':scope > .operations-panel .operations-subprocess[data-search]');
                            subProcesses.forEach((subProcess) => {
                                subProcess.style.display = '';
                            });
                        });
                    }

                    group.style.display = groupVisible ? '' : 'none';
                    syncAccordion(group, groupVisible);
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
