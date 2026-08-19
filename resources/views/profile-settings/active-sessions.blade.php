<main class="relative mx-auto mt-6 w-full max-w-4xl pb-8">
  <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-col gap-5 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-5 py-6 sm:flex-row sm:items-center sm:justify-between sm:px-7">
      <div class="flex items-start gap-4">
        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-900 text-lg text-white shadow-sm"><i class="fas fa-laptop"></i></span>
        <div>
          <h1 class="text-xl font-bold text-slate-900">Active sessions</h1>
          <p class="mt-1 text-sm text-slate-500">Review browsers signed in to your account and log out any session you do not recognize.</p>
        </div>
      </div>
      <span class="inline-flex w-fit items-center gap-2 rounded-full bg-blue-100 px-3 py-1.5 text-xs font-bold text-blue-700"><i class="fas fa-desktop"></i> {{ $sessions->count() }} {{ Str::plural('session', $sessions->count()) }}</span>
    </div>

    <div class="px-5 py-6 sm:px-7">
      <section class="overflow-hidden rounded-xl border border-slate-200" aria-labelledby="active-sessions-title">
        <div class="border-b border-slate-100 px-5 py-4">
          <h2 id="active-sessions-title" class="font-semibold text-slate-800">Signed-in browsers</h2>
          <p class="mt-1 text-sm text-slate-500">Remove access from any browser or device you no longer use.</p>
        </div>
        <div class="divide-y divide-slate-100">
          @forelse ($sessions as $session)
            <article class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
              <div class="flex min-w-0 items-start gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $session->is_current ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}"><i class="fas fa-desktop"></i></span>
                <div class="min-w-0">
                  <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-sm font-semibold text-slate-800">{{ $session->browser }} on {{ $session->platform }}</h3>
                    @if ($session->is_current)
                      <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-700">Current browser</span>
                    @endif
                  </div>
                  <p class="mt-1 text-xs text-slate-500">{{ $session->ip_address ?? 'Unknown IP' }} &middot; Last active {{ $session->last_active_at->diffForHumans() }}</p>
                </div>
              </div>
              <form method="POST" action="{{ route('active.sessions.destroy', $session) }}" class="shrink-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-xs font-bold uppercase tracking-wide text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2" onclick="return confirm('Log out this browser session?')"><i class="fas fa-right-from-bracket"></i> {{ $session->is_current ? 'Log out' : 'Log out browser' }}</button>
              </form>
            </article>
          @empty
            <div class="px-5 py-10 text-center">
              <span class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-400"><i class="fas fa-laptop"></i></span>
              <p class="mt-3 text-sm font-medium text-slate-700">No active browser sessions</p>
              <p class="mt-1 text-xs text-slate-500">Signed-in browsers will appear here.</p>
            </div>
          @endforelse
        </div>
      </section>
    </div>
  </section>
</main>
