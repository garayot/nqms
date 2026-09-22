<header class="border-b border-slate-200 bg-white/95 backdrop-blur">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#0f3d68] text-sm font-bold text-white">DepEd</div>
            <div>
                <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Bislig City</div>
                <div class="text-sm font-semibold text-slate-800">NQMS</div>
            </div>
        </a>

        <div class="hidden items-center gap-6 text-sm font-medium text-slate-700 md:flex">
            <a href="{{ route('home') }}" class="hover:text-[#0f3d68]">Home</a>
            <a href="{{ route('forms.index') }}" class="hover:text-[#0f3d68]">Forms and Templates</a>
            <a href="{{ route('links') }}" class="hover:text-[#0f3d68]">Links</a>
            <a href="{{ route('organization') }}" class="hover:text-[#0f3d68]">Organization</a>
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-[#0f3d68]">Dashboard</a>
                <a href="{{ route('draf.index') }}" class="hover:text-[#0f3d68]">DRAF / Document Management</a>
            @endauth
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="hidden rounded-md bg-slate-100 px-3 py-2 text-sm font-medium text-slate-800 sm:inline-flex">My Workspace</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Logout</button>
                </form>
            @else
                <a href="{{ route('login.google') }}" class="rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0b2f52]">Login with Google</a>
            @endauth
        </div>
    </nav>
</header>
