@props(['title' => 'Tidak ada data', 'subtitle' => ''])
<div class="col-span-full flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
  <div class="size-12 rounded-2xl bg-slate-100 grid place-items-center">
    <x-admin.icon name="layers" class="size-6 text-slate-400"/>
  </div>
  <h3 class="mt-4 text-base font-semibold text-slate-800">{{ $title }}</h3>
  @if($subtitle)
    <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
  @endif
  {{ $slot }}
</div>
