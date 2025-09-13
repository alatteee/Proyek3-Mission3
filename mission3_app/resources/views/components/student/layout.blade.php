@props(['title' => 'Student'])

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title }} — Student</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
  <div class="min-h-screen flex">

    {{-- SIDEBAR: layout yang pegang aside --}}
    <aside class="hidden md:block w-64 shrink-0 bg-white border-r border-slate-200">
      <div class="flex items-center gap-3 px-4 py-4">
        <span class="font-bold text-2xl text-emerald-600">Academia</span>
      </div>

      @include('student.partials.sidebar-inner') 
    </aside>

    <main class="flex-1">
      <header class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="h-16 max-w-6xl mx-auto px-4 flex items-center w-full">
          <h1 class="text-lg font-semibold">{{ $title }}</h1>
          <div class="flex-1"></div>
          <div class="flex items-center gap-4">
            <div class="text-right leading-tight">
              <p class="font-semibold text-slate-900">{{ auth()->user()->full_name ?? auth()->user()->username }}</p>
              <p class="text-sm text-slate-500 capitalize">{{ auth()->user()->role ?? 'student' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="rounded-lg bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-500">
                Logout
              </button>
            </form>
          </div>
        </div>
      </header>

      <div class="max-w-6xl mx-auto px-4 py-6">
        {{ $slot }}
      </div>
    </main>
  </div>
</body>
</html>
