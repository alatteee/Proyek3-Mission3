@php
  $is = fn($pat) => request()->routeIs($pat)
      ? 'bg-indigo-500/90 text-white'  
      : 'text-slate-600 hover:bg-slate-100';
@endphp

<div class="h-[calc(100vh-4rem)] sticky top-16 rounded-r-2xl">
  <nav class="p-2 space-y-1">

    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}" 
       class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('admin.dashboard') }}">
      <svg xmlns="http://www.w3.org/2000/svg" 
           fill="none" viewBox="0 0 24 24" 
           stroke-width="1.5" stroke="currentColor" 
           class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" 
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
      </svg>
      <span class="text-sm font-medium">Dashboard</span>
    </a>

    {{-- Courses --}}
    <a href="{{ route('admin.courses.index') }}" 
      class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('admin.courses.index') }}">
      <svg xmlns="http://www.w3.org/2000/svg" 
          fill="none" viewBox="0 0 24 24" 
          stroke-width="1.5" stroke="currentColor" 
          class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" 
              d="M12 6.75c-1.148-1.067-2.986-1.5-4.5-1.5S4.148 5.683 3 6.75v10.5c1.148-1.067 2.986-1.5 4.5-1.5s3.352.433 4.5 1.5m0-10.5v10.5m0-10.5c1.148-1.067 2.986-1.5 4.5-1.5s3.352.433 4.5 1.5v10.5c-1.148-1.067-2.986-1.5-4.5-1.5s-3.352.433-4.5 1.5" />
      </svg>
      <span class="text-sm font-medium">Courses</span>
    </a>

    {{-- Students (pakai users) --}}
    <a href="{{ route('admin.students.index') }}" 
      class="flex items-center gap-3 rounded-xl px-3 py-2 {{ $is('admin.students.index') }}">
      <svg xmlns="http://www.w3.org/2000/svg" 
          fill="none" viewBox="0 0 24 24" 
          stroke-width="1.5" stroke="currentColor" 
          class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" 
              d="M15 19.128v-.856A2.25 2.25 0 0012.75 16h-1.5A2.25 2.25 0 009 18.272v.856M18 8.25A2.25 2.25 0 1113.5 6a2.25 2.25 0 014.5 2.25zM5.25 8.25A2.25 2.25 0 1110 6a2.25 2.25 0 01-4.5 2.25zM4.5 19.128v-.856A2.25 2.25 0 016.75 16h1.5A2.25 2.25 0 0110.5 18.272v.856M19.5 19.128v-.856A2.25 2.25 0 0017.25 16h-1.5a2.25 2.25 0 00-2.25 2.272v.856" />
      </svg>
      <span class="text-sm font-medium">Students</span>
    </a>


  </nav>
</div>
