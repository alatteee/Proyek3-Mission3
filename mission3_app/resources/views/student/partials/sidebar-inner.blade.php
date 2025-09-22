@php
  $is = fn($pat) => request()->routeIs($pat)
      ? 'bg-emerald-100 text-emerald-700'
      : 'text-slate-700 hover:bg-slate-50';
@endphp

<div class="h-[calc(100vh-4rem)] sticky top-16 rounded-r-2xl">
  <nav class="p-2 space-y-1">

    {{-- Dashboard --}}
    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('student.dashboard') }}">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m0 0h8a2 2 0 002-2v-6a2 2 0 00-2-2h-8a2 2 0 00-2 2v6z" />
      </svg>
      <span class="text-sm font-medium">Dashboard</span>
    </a>

    {{-- Browse Courses --}}
    <a href="{{ route('student.courses.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('student.courses.index') }}">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v7m0-7l-9-5m9 5l9-5" />
      </svg>
      <span class="text-sm font-medium">Browse Courses</span>
    </a>

    {{-- My Courses --}}
    <a href="{{ route('student.courses.mine') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('student.courses.mine') }}">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V7a2 2 0 00-2-2h-4.586a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 008.586 2H5a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2z" />
      </svg>
      <span class="text-sm font-medium">My Courses</span>
    </a>

  </nav>
</div>
