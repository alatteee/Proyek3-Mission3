@props(['label' => 'Label', 'value' => 0, 'icon' => 'chart', 'accent' => 'indigo'])

@php
  // Map warna yg aman untuk Tailwind (tidak dipurge)
  $bgMap = [
    'indigo'  => 'bg-indigo-600',
    'teal'    => 'bg-teal-600',
    'sky'     => 'bg-sky-600',
    'emerald' => 'bg-emerald-600',
    'rose'    => 'bg-rose-600',
    'amber'   => 'bg-amber-600',
  ];
  $bg = $bgMap[$accent] ?? $bgMap['indigo'];
@endphp

<div class="{{ $bg }} text-white rounded-2xl p-5 shadow-sm">
  <div class="flex items-center justify-between">
    <div class="text-4xl font-bold leading-none">{{ $value }}</div>
    <div class="bg-white/15 rounded-xl p-2">
      <x-admin.icon :name="$icon" class="size-6" />
    </div>
  </div>
  <div class="mt-2 text-sm/5 opacity-90">{{ $label }}</div>
</div>
