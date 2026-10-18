<aside class="w-full rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:w-72 lg:shrink-0">
    @php
        $defaultLinkClass = 'block rounded-lg border border-transparent px-3 py-2 whitespace-nowrap hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]';
        $activeLinkClass = 'block rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 whitespace-nowrap text-[#0f3d68]';
    @endphp

    <div class="mb-5 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Navigation</div>
    <nav class="space-y-4 text-sm font-medium text-slate-600">
        <div>
            <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Main</div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $activeLinkClass : $defaultLinkClass }}">Dashboard</a>
                <a href="{{ route('draf.index') }}" class="{{ request()->routeIs('draf.*') ? $activeLinkClass : $defaultLinkClass }}">My Submissions</a>
            </div>
        </div>

        <div>
            <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Profile</div>
            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? $activeLinkClass : $defaultLinkClass }}">Manage Profile</a>
            </div>
        </div>

        <div>
            <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Shortcuts</div>
            <div class="space-y-1">
                <a href="https://depedph-my.sharepoint.com/:f:/g/personal/willy_dumpit001_deped_gov_ph/IgBBtP_jP-ZfT4qxTi4J7N3NAeBg77coDWKEmrZmo9_SYIA?e=fiOURx" target="_blank" class="{{ $defaultLinkClass }}">NQMS Documents</a>
            </div>
        </div>

        @if (auth()->user()?->isAdmin())
            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">QMS Library</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.qms-organization.index') }}" class="{{ request()->routeIs('admin.qms-organization.*') ? $activeLinkClass : $defaultLinkClass }}">QMS Organization</a>
                    <a href="{{ route('admin.planning-docs.index') }}" class="{{ request()->routeIs('admin.planning-docs.*') ? $activeLinkClass : $defaultLinkClass }}">Planning Docs</a>
                    <a href="{{ route('admin.operations-manual.index') }}" class="{{ request()->routeIs('admin.operations-manual.*') ? $activeLinkClass : $defaultLinkClass }}">Operations Manual</a>
                    <a href="{{ route('admin.nqms-manuals.index') }}" class="{{ request()->routeIs('admin.nqms-manuals.*') ? $activeLinkClass : $defaultLinkClass }}">NQMS Manual</a>
                    <a href="{{ route('admin.iso-portal.index') }}" class="{{ request()->routeIs('admin.iso-portal.*', 'admin.form-templates.*') ? $activeLinkClass : $defaultLinkClass }}">ISO Portal Management</a>
                    <a href="{{ route('admin.qms-teams.index') }}" class="{{ request()->routeIs('admin.qms-teams.*') ? $activeLinkClass : $defaultLinkClass }}">QMS Teams</a>
                </div>
            </div>

            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Workflow</div>
                <div class="space-y-1">
                    <a href="{{ route('reviewer.drafs.index') }}" class="{{ request()->routeIs('reviewer.*') ? $activeLinkClass : $defaultLinkClass }}">Review DRAFs</a>
                    <a href="{{ route('approver.drafs.index') }}" class="{{ request()->routeIs('approver.*') ? $activeLinkClass : $defaultLinkClass }}">Approver Queue</a>
                </div>
            </div>

            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Administration</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.document-types.index') }}" class="{{ request()->routeIs('admin.document-types.*') ? $activeLinkClass : $defaultLinkClass }}">Document Types</a>
                    <a href="{{ route('admin.func-divs.index') }}" class="{{ request()->routeIs('admin.func-divs.*') ? $activeLinkClass : $defaultLinkClass }}">Functional Divisions</a>
                    <a href="{{ route('admin.offices.index') }}" class="{{ request()->routeIs('admin.offices.*') ? $activeLinkClass : $defaultLinkClass }}">Offices</a>
                    <a href="{{ route('admin.positions.index') }}" class="{{ request()->routeIs('admin.positions.*') ? $activeLinkClass : $defaultLinkClass }}">Positions</a>
                    <a href="{{ route('admin.reasons.index') }}" class="{{ request()->routeIs('admin.reasons.*') ? $activeLinkClass : $defaultLinkClass }}">Reasons</a>
                </div>
            </div>

            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Settings</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? $activeLinkClass : $defaultLinkClass }}">Users</a>
                    <a href="{{ route('admin.whitelist.index') }}" class="{{ request()->routeIs('admin.whitelist.*') ? $activeLinkClass : $defaultLinkClass }}">Whitelist</a>
                </div>
            </div>
        @endif

        @if (auth()->user()?->isReviewer() && ! auth()->user()?->isAdmin())
            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Workflow</div>
                <div class="space-y-1">
                    <a href="{{ route('reviewer.drafs.index') }}" class="{{ request()->routeIs('reviewer.*') ? $activeLinkClass : $defaultLinkClass }}">Review DRAFs</a>
                </div>
            </div>
        @endif

        @if (auth()->user()?->isApprover() && ! auth()->user()?->isAdmin())
            <div>
                <div class="mb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Workflow</div>
                <div class="space-y-1">
                    <a href="{{ route('approver.drafs.index') }}" class="{{ request()->routeIs('approver.*') ? $activeLinkClass : $defaultLinkClass }}">Approver Queue</a>
                </div>
            </div>
        @endif
    </nav>
</aside>
