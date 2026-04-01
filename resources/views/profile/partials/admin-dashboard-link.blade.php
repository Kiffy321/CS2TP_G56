<section>
    @if(auth()->user() && (auth()->user()->is_admin ?? false))
        <div class="flex items-center gap-4 mt-6">
            <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-3 bg-yellow-600 text-white font-semibold rounded hover:bg-yellow-700 transition text-center w-full">
                Go to Admin Dashboard
            </a>
        </div>
    @endif
</section>