@php
  $is = fn($pat) => request()->routeIs($pat)
      ? 'bg-emerald-600 text-white'
      : 'text-slate-700 hover:bg-slate-50';
@endphp

<div class="h-[calc(100vh-4rem)] sticky top-16 rounded-r-2xl">
  <nav class="p-2 space-y-1">
    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('student.dashboard') }}">
      <span class="text-sm font-medium">Dashboard</span>
    </a>
    <a href="{{ route('student.courses.index') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('student.courses.index') }}">
      <span class="text-sm font-medium">Browse Courses</span>
    </a>
    <a href="{{ route('student.courses.mine') }}" class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('student.courses.mine') }}">
      <span class="text-sm font-medium">My Courses</span>
    </a>
  </nav>
</div>
