@props([
  'label' => '',
  'for' => null,
  'hint' => null,
  'error' => null
])

<div class="space-y-1.5">
  @if($label)
    <label for="{{ $for }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>
  @endif

  {{ $slot }}

  @if($hint)
    <p class="text-[13px] text-slate-500">{{ $hint }}</p>
  @endif

  @if($error)
    <p class="text-[13px] text-red-600">{{ $error }}</p>
  @endif
</div>
