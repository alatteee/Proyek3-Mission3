@props(['cancel' => null, 'saving' => 'Save'])

<div class="flex items-center gap-3 pt-2">
  <button type="submit"
          class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-indigo-600 text-white
                 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/50">
    {{ $saving }}
  </button>

  @if($cancel)
    <a href="{{ $cancel }}"
       class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50">
      Cancel
    </a>
  @endif
</div>
