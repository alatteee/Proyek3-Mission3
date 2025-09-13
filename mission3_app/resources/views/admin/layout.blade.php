<x-app-layout>
  {{-- judul di bar atas Breeze --}}
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-900">{{ $title ?? '' }}</h2>
  </x-slot>

  {{-- wrapper halaman di bawah header --}}
  <div class="bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      {{-- 4rem = 64px = tinggi header Breeze (h-16) --}}
      <div class="flex gap-6 min-h-[calc(100vh-4rem)]">
        @include('admin.partials.sidebar')

        {{-- area konten --}}
        <main class="flex-1 py-6">
          {{ $slot }}
        </main>
      </div>
    </div>
  </div>
</x-app-layout>
