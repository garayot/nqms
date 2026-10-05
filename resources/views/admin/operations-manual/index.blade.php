@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Operations Manual</h1>
                    <p class="mt-2 text-sm text-slate-600">Manage process groups for the operations manual hierarchy.</p>
                </div>
                <a href="{{ route('admin.operations-manual.process-groups.create') }}" class="inline-flex items-center rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">+ Add Process Group</a>
            </div>
        </div>

        <div class="space-y-4" id="operations-manual-container">
            @forelse ($processGroups as $processGroup)
                <section class="operations-group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm" data-expanded="false">
                    <h2>
                        <button type="button" class="operations-toggle flex w-full items-center justify-between gap-3 border-b border-slate-200 bg-blue-50 px-4 py-4 text-left text-lg font-semibold text-[#0f3d68] transition-colors hover:bg-blue-100" aria-expanded="false" aria-controls="operations-group-panel-{{ $processGroup->id }}" id="operations-group-trigger-{{ $processGroup->id }}">
                            <span>{{ $processGroup->process_group_name }}</span>
                            <svg data-accordion-icon class="operations-icon h-5 w-5 shrink-0 text-[#0f3d68] transition-transform duration-200 ease-out" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 9 7 7 7-7" />
                            </svg>
                        </button>
                    </h2>

                    <div id="operations-group-panel-{{ $processGroup->id }}" role="region" aria-labelledby="operations-group-trigger-{{ $processGroup->id }}" class="operations-panel grid grid-rows-[0fr] overflow-hidden opacity-0 transition-all duration-300 ease-in-out">
                        <div class="space-y-3 overflow-hidden p-4">
                            <div class="flex flex-wrap items-center gap-2">
                                @if ($processGroup->url)
                                    <a href="{{ $processGroup->url }}" target="_blank" rel="noopener noreferrer" class="rounded-md bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200">Open Link</a>
                                @else
                                    <span class="rounded-md bg-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">No Link</span>
                                @endif

                                <a href="{{ route('admin.operations-manual.processes.create', $processGroup) }}" class="rounded-md bg-[#0f3d68] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#0b2f52]">+ Add Process</a>
                                <a href="{{ route('admin.operations-manual.processes.index', $processGroup) }}" class="rounded-md bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-200">View All</a>
                                <a href="{{ route('admin.operations-manual.process-groups.edit', $processGroup) }}" class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">Edit</a>
                                <form method="POST" action="{{ route('admin.operations-manual.process-groups.destroy', $processGroup) }}" onsubmit="return confirm('Delete this process group? All related processes and sub-processes will also be deleted.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Delete</button>
                                </form>
                            </div>

                            <div class="space-y-2">
                                @forelse ($processGroup->processes as $process)
                                    <div class="overflow-hidden rounded-lg border border-slate-200">
                                        <div class="flex flex-col gap-3 bg-white px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="text-sm font-medium text-slate-800">{{ $process->process_name }}</div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="rounded-md bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700">{{ $process->sub_processes_count }} Sub-process{{ $process->sub_processes_count === 1 ? '' : 'es' }}</span>
                                                <a href="{{ route('admin.operations-manual.sub-processes.index', [$processGroup, $process]) }}" class="rounded-md bg-blue-100 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-200">Manage</a>
                                                <a href="{{ route('admin.operations-manual.processes.edit', [$processGroup, $process]) }}" class="rounded-md bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-200">Edit</a>
                                                <form method="POST" action="{{ route('admin.operations-manual.processes.destroy', [$processGroup, $process]) }}" onsubmit="return confirm('Delete this process? All related sub-processes will also be deleted.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-md bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-lg border border-dashed border-slate-300 px-4 py-3 text-sm text-slate-500">
                                        No processes have been added for this process group.
                                        <a href="{{ route('admin.operations-manual.processes.create', $processGroup) }}" class="ml-2 font-semibold text-[#0f3d68] hover:text-[#0b2f52]">+ Add Process</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-slate-500 shadow-sm">
                    No process groups found.
                    <div class="mt-4">
                        <a href="{{ route('admin.operations-manual.process-groups.create') }}" class="inline-flex items-center rounded-lg bg-[#0f3d68] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0b2f52]">+ Add Process Group</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        (() => {
            const syncAccordion = (accordion, expanded) => {
                const panel = accordion.querySelector(':scope > .operations-panel');
                const trigger = accordion.querySelector(':scope > h2 > .operations-toggle');
                const icon = accordion.querySelector(':scope > h2 .operations-icon');

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
                const accordion = button.closest('.operations-group');

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
