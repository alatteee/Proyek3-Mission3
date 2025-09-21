@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }} — Admin</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-900 dark:text-slate-100">
  <div class="min-h-screen flex">

    {{-- SIDEBAR: layout yang pegang aside --}}
    <aside class="hidden md:block w-64 shrink-0 bg-white border-r border-slate-200 dark:bg-slate-800 dark:border-slate-700">
      <div class="flex items-center gap-3 px-4 py-4">
        <span class="font-bold text-2xl text-indigo-600">Academia</span>
      </div>
      @include('admin.partials.sidebar-inner') {{-- <— isi tanpa <aside> --}}
    </aside>

    <main class="flex-1">
      {{-- HEADER tinggi tetap 64px agar sinkron dengan sticky sidebar top-16 --}}
      <header class="sticky top-0 z-10 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="h-16 max-w-6xl mx-auto px-4 flex items-center w-full">
          <h1 class="text-lg font-semibold">{{ $title }}</h1>
          <div class="flex-1"></div>
          <div class="flex items-center gap-4">
            <div class="text-right leading-tight">
              <p class="font-semibold text-slate-900">
                {{ auth()->user()->full_name ?? auth()->user()->name ?? 'Administrator' }}
              </p>
              <p class="text-sm text-slate-500 capitalize">{{ auth()->user()->role ?? 'admin' }}</p>
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
        <button id="cancelBtn" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Batal</button>
        <button id="okBtn" class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-500">Hapus</button>
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

  <!-- Bulk Action Confirmation Modal -->
  <div id="bulkModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Aksi</h2>
      <p id="bulkMessage" class="text-gray-600 mb-6">Apakah kamu yakin?</p>
      <div class="flex justify-end gap-3">
        <button id="cancelBulkBtn" type="button"
                class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Batal</button>
        <button id="okBulkBtn" type="button"
                class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-500">Lanjutkan</button>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</body>
</html>
