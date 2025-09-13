@props(['href' => '#', 'icon' => 'circle', 'active' => false])

<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2 rounded-lg
     {{ $active ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
  <x-admin.icon :name="$icon" class="size-5" />
  <span class="text-sm font-medium">{{ $slot }}</span>
</a>
