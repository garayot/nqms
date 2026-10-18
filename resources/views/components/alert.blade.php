@if (session('success'))
    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('auth_required'))
    <div id="auth-required-toast-wrapper" class="fixed inset-x-0 top-4 z-[70] px-4 sm:px-6 lg:inset-x-auto lg:right-6 lg:left-auto lg:w-full lg:max-w-sm lg:px-0">
        <div id="auth-required-toast" class="pointer-events-auto transform rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800 shadow-lg transition-all duration-300 ease-out translate-y-[-8px] opacity-0 lg:translate-x-6 lg:translate-y-0">
            <div class="flex items-start gap-3">
                <div class="min-w-0 flex-1">
                    Please <a href="{{ route('login.google') }}" class="font-semibold underline underline-offset-2">log in</a> to view or download repository files.
                </div>
                <button id="auth-required-toast-close" type="button" class="inline-flex h-6 w-6 items-center justify-center rounded-md text-blue-700 hover:bg-blue-100" aria-label="Close notification">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const toast = document.getElementById('auth-required-toast');
            const wrapper = document.getElementById('auth-required-toast-wrapper');
            const closeButton = document.getElementById('auth-required-toast-close');

            if (!toast || !wrapper) {
                return;
            }

            const showToast = () => {
                toast.classList.remove('opacity-0');
                toast.classList.remove('translate-y-[-8px]');
                toast.classList.remove('lg:translate-x-6');
                toast.classList.add('opacity-100');
                toast.classList.add('translate-y-0');
                toast.classList.add('lg:translate-x-0');
            };

            const hideToast = () => {
                toast.classList.remove('opacity-100');
                toast.classList.remove('translate-y-0');
                toast.classList.remove('lg:translate-x-0');
                toast.classList.add('opacity-0');
                toast.classList.add('translate-y-[-8px]');
                toast.classList.add('lg:translate-x-6');

                window.setTimeout(() => {
                    wrapper.remove();
                }, 300);
            };

            window.setTimeout(showToast, 50);

            const autoHideTimer = window.setTimeout(hideToast, 5000);

            if (closeButton) {
                closeButton.addEventListener('click', function () {
                    window.clearTimeout(autoHideTimer);
                    hideToast();
                });
            }
        })();
    </script>
@endif
