@props(['title' => 'Student'])

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }} — Student</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased dark:bg-slate-900 dark:text-slate-100">
  <div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-slate-200 dark:bg-slate-800 dark:border-slate-700 flex flex-col">
      {{-- Logo --}}
      <div class="flex items-center gap-3 px-4 py-4 border-b border-slate-200 dark:border-slate-700">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png" 
            alt="Logo" 
            class="h-8 w-8 object-contain">
        <span class="font-bold text-2xl text-emerald-600">Academia</span>
      </div>

      {{-- menu --}}
      <div class="flex-1 overflow-y-auto">
        @include('student.partials.sidebar-inner') 
      </div>
    </aside>

    {{-- MAIN --}}
    <main class="ml-64 flex-1">
      <header class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="h-16 max-w-6xl mx-auto px-4 flex items-center w-full">
          <h1 class="text-lg font-semibold">{{ $title }}</h1>
          <div class="flex-1"></div>
          <div class="flex items-center gap-4">
            <div class="text-right leading-tight">
              <p class="font-semibold text-slate-900">{{ auth()->user()->full_name ?? auth()->user()->username }}</p>
              <p class="text-sm text-slate-500 capitalize">{{ auth()->user()->role ?? 'student' }}</p>
            </div>
            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="button"
                      id="logoutBtn"
                      class="rounded-lg bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-500">
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

  <!-- Delete Confirmation Modal -->
  <div id="confirmModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Hapus</h2>
      <p id="confirmMessage" class="text-gray-600 mb-6">Apakah kamu yakin?</p>
      <div class="flex justify-end gap-3">
        <button id="cancelBtn" type="button"
                class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Batal</button>
        <button id="okBtn" type="button"
                class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-500">Hapus</button>
      </div>
    </div>
  </div>

  <!-- Bulk Enroll Confirmation Modal -->
  <div id="enrollModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Enroll</h2>
      <p id="enrollMessage" class="text-gray-600 mb-6">Apakah kamu yakin?</p>
      <div class="flex justify-end gap-3">
        <button id="cancelEnrollBtn" type="button" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Batal</button>
        <button id="okEnrollBtn" type="button"
                class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-500">
          Enroll
        </button>
      </div>
    </div>
  </div>

    <!-- Logout Confirmation Modal -->
  <div id="logoutModal"
      class="hidden fixed inset-0 flex items-center justify-center bg-black/50 z-50">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
      <h2 class="text-lg font-semibold mb-3">Logout Confirmation</h2>
      <p class="text-slate-600">Are you sure want to logout?</p>

      <div class="mt-6 flex justify-end gap-3">
        <button id="cancelLogoutBtn"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
          Cancel
        </button>
        <button id="confirmLogoutBtn"
                class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-500">
          Logout
        </button>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</body>
</html>
