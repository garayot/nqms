<aside class="w-full rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:w-72 lg:shrink-0">
    <div class="mb-5 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Navigation</div>
    <nav class="space-y-4 text-sm font-medium text-slate-600">
        <div>
            <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Main</div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Dashboard</a>
                <a href="{{ route('draf.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">My Submissions</a>
            </div>
        </div>

        @if (auth()->user()?->isAdmin())
            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">QMS Library</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.planning-docs.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Planning Docs</a>
                    <a href="{{ route('admin.operations-manual.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Operations Manual</a>
                    <a href="{{ route('admin.form-templates.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Forms and Templates</a>
                    <a href="{{ route('admin.qms-teams.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">QMS Teams</a>
                </div>
            </div>

            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Workflow</div>
                <div class="space-y-1">
                    <a href="{{ route('reviewer.drafs.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Review DRAFs</a>
                    <a href="{{ route('approver.drafs.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Approver Queue</a>
                </div>
            </div>

            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Administration</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.document-types.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Document Types</a>
                    <a href="{{ route('admin.func-divs.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Functional Divisions</a>
                    <a href="{{ route('admin.offices.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Offices</a>
                    <a href="{{ route('admin.positions.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Positions</a>
                    <a href="{{ route('admin.users.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Users</a>
                    <a href="{{ route('admin.whitelist.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Whitelist</a>
                </div>
            </div>
        @endif

        @if (auth()->user()?->isReviewer() && ! auth()->user()?->isAdmin())
            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Workflow</div>
                <div class="space-y-1">
                    <a href="{{ route('reviewer.drafs.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Review DRAFs</a>
                </div>
            </div>
        @endif

        @if (auth()->user()?->isApprover() && ! auth()->user()?->isAdmin())
            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Workflow</div>
                <div class="space-y-1">
                    <a href="{{ route('approver.drafs.index') }}" class="block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Approver Queue</a>
                </div>
            </div>
        @endif
    </nav>
</aside>
