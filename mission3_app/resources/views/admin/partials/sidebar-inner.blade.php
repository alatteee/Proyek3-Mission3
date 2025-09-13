@php
  $is = fn($pat) => request()->routeIs($pat)
      ? 'bg-indigo-600 text-white'
      : 'text-slate-700 hover:bg-slate-50';
@endphp

<div class="h-[calc(100vh-4rem)] sticky top-16 rounded-r-2xl">
  
  {{-- Nav --}}
  <nav class="p-2 space-y-1">
    <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 {{ $is('admin.dashboard') }}">
      <svg class="h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}"
           fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10h4m10-11l2 2v9h-4m-6 0h6"/>
      </svg>
      <span class="text-sm font-medium">Dashboard</span>
    </a>

    <a href="{{ route('admin.courses.index') }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 {{ $is('admin.courses*') }}">
      <svg class="h-5 w-5 {{ request()->routeIs('admin.courses*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}"
           fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10M4 18h6"/>
      </svg>
      <span class="text-sm font-medium">Courses</span>
    </a>

    <a href="{{ route('admin.students.index') }}" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 {{ $is('admin.students*') }}">
      <svg class="h-5 w-5 {{ request()->routeIs('admin.students*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100' }}"
           fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1M16 7a4 4 0 11-8 0 4 4 0 018 0z"/>
      </svg>
      <span class="text-sm font-medium">Students</span>
    </a>
  </nav>
</div>
