@props(['title' => null, 'subtitle' => null])

<section class="bg-white rounded-2xl shadow-sm border border-slate-200">
  @if($title)
    <div class="px-6 py-4 border-b border-slate-100">
      <h2 class="text-base font-semibold text-slate-800">{{ $title }}</h2>
      @if($subtitle)
        <p class="text-sm text-slate-500 mt-0.5">{{ $subtitle }}</p>
      @endif
    </div>
  @endif

  <div class="p-6">
    {{ $slot }}
  </div>
</section>
