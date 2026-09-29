<header class="relative z-50 isolate w-full border-b border-slate-200 bg-white/90 shadow-sm backdrop-blur">
    <nav class="relative flex w-full items-center px-4 py-4 sm:px-6 lg:px-8 md:grid md:grid-cols-[auto_minmax(0,1fr)_auto] md:items-center md:gap-8">
        <a href="{{ route('home') }}" class="flex flex-none items-center gap-3 md:justify-self-start">
            <img src="{{ Storage::url('logo/Bislig SDO logo.png') }}" alt="Bislig SDO logo" class="h-12 w-12 rounded-full object-cover">

            <div class="leading-tight">
                <div class="text-xs uppercase tracking-[0.2em] text-slate-500">Bislig City Division</div>
                <div class="text-sm font-semibold text-slate-800">NQMS</div>
            </div>
        </a>

        <div class="hidden min-w-0 items-center justify-center gap-2 text-sm font-medium text-slate-700 md:flex md:w-full md:flex-wrap md:justify-center lg:gap-4 xl:gap-6">
            <a href="{{ route('home') }}" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">Home</a>
            <a href="#" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">NQMS Manual</a>
            <a href="#" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">Planning Docs</a>
            <a href="{{ route('operations-manual') }}" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">Operations Manual</a>
            <a href="{{ route('forms.index') }}" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">Forms and Templates</a>
            <a href="{{ route('links') }}" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">Links</a>
            <a href="{{ route('organization') }}" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">QMS Team</a>
            <a href="#" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">ISO Portal</a>
            @auth
                <a href="{{ route('dashboard') }}" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">Dashboard</a>
                <!-- <a href="{{ route('draf.index') }}" class="whitespace-nowrap rounded-md border border-transparent px-3 py-2 hover:border-slate-200 hover:bg-slate-50 hover:text-[#0f3d68]">DRAF / Document Management</a> -->
            @endauth
        </div>

        <div class="ml-auto flex flex-none items-center gap-3 md:ml-0 md:justify-self-end">
            <details class="relative z-50 md:hidden">
            <summary class="relative z-50 ml-auto flex h-10 w-10 cursor-pointer list-none items-center justify-center rounded-md border border-slate-300 bg-white text-slate-700 hover:bg-slate-100 [&::-webkit-details-marker]:hidden">
                    <span class="sr-only">Open navigation menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </summary>

                <div class="absolute right-0 top-full z-50 mt-2 w-72 rounded-lg border border-slate-200 bg-white p-2 shadow-lg ring-1 ring-slate-200/60">
                    <div class="flex flex-col text-sm font-medium text-slate-700">
                        <a href="{{ route('home') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">Home</a>
                        <a href="#" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">NQMS Manual</a>
                        <a href="#" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">Planning Docs</a>
                        <a href="{{ route('operations-manual') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">Operations Manual</a>
                        <a href="{{ route('forms.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">Forms and Templates</a>
                        <a href="{{ route('links') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">Links</a>
                        <a href="{{ route('organization') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">QMS Team</a>
                        <a href="#" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">ISO Portal</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">Dashboard</a>
                            <div class="my-1 border-t border-slate-200"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full rounded-md px-3 py-2 text-left hover:bg-slate-100 hover:text-[#0f3d68]">Logout</button>
                            </form>
                        @else
                            <div class="my-1 border-t border-slate-200"></div>
                            <a href="{{ route('login.google') }}" class="rounded-md px-3 py-2 hover:bg-slate-100 hover:text-[#0f3d68]">Login with Google</a>
                        @endauth
                    </div>
                </div>
            </details>

            @auth
                
                <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m-6-3h11.25m0 0-3-3m3 3-3 3" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login.google') }}" class="hidden items-center gap-2 rounded-md bg-[#0f3d68] px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[#0b2f52] md:inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m10 17 5-5-5-5" />
                        <path d="M15 12H3" />
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                    </svg>
                    <span>Login</span>
                </a>
            @endauth
        </div>
    </nav>
</header>
