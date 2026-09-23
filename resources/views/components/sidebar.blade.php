<aside class="w-full rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:w-72">
    <div class="mb-5 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Navigation</div>
    <nav class="space-y-2 text-sm font-medium text-slate-600">
        <a href="{{ route('dashboard') }}" class="block rounded-lg border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Dashboard</a>
        <a href="{{ route('draf.index') }}" class="block rounded-lg border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">My Submissions</a>
        <a href="{{ route('forms.index') }}" class="block rounded-lg border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Forms and Templates</a>
        @if (auth()->user()?->isAdmin())
            <a href="{{ route('admin.drafs.index') }}" class="block rounded-lg border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Admin: DRAFs</a>
            <a href="{{ route('admin.users.index') }}" class="block rounded-lg border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Users</a>
            <a href="{{ route('admin.whitelist.index') }}" class="block rounded-lg border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Whitelist</a>
            <a href="{{ route('admin.document-types.index') }}" class="block rounded-lg border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Document Types</a>
        @endif
        @if (auth()->user()?->isApprover())
            <a href="{{ route('approver.drafs.index') }}" class="block rounded-lg border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-100 hover:text-[#0f3d68]">Approver Queue</a>
        @endif
    </nav>
</aside>
