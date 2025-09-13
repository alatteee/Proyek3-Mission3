@props([
  'code' => 'IF101',
  'name' => 'Nama Mata Kuliah',
  'credits' => 3,
  'desc' => null,
  'enrolled' => false,
])

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
  <div class="flex items-start justify-between">
    <div>
      <div class="text-xs font-medium tracking-wide text-slate-500">{{ $code }}</div>
      <div class="mt-0.5 font-semibold text-slate-800">{{ $name }}</div>
    </div>
    <span class="text-xs rounded-lg px-2 py-1 {{ $enrolled ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
      {{ $credits }} SKS
    </span>
  </div>

  @if($desc)
    <div class="mt-3 text-sm text-slate-600 line-clamp-2">{{ $desc }}</div>
  @endif

  <div class="mt-4">
    {{ $slot }} {{-- tempat tombol Enroll/Unenroll --}}
  </div>
</div>
