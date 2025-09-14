<x-student.layout title="My Courses">
  @if(session('ok'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">
      {{ session('ok') }}
    </div>
  @endif

  <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-700">
        <tr>
          <th class="px-4 py-3 text-left font-semibold">Code</th>
          <th class="px-4 py-3 text-left font-semibold">Name</th>
          <th class="px-4 py-3 text-left font-semibold">Enrolled At</th>
          <th class="px-4 py-3 text-left font-semibold">Grade</th>
          <th class="px-4 py-3 text-right font-semibold">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200 text-slate-900">
        @forelse($courses as $c)
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 font-mono">{{ $c->course_code }}</td>
            <td class="px-4 py-3">{{ $c->course_name }}</td>
            <td class="px-4 py-3">{{ \Illuminate\Support\Carbon::parse($c->pivot->enroll_date)->format('d M Y') }}</td>
            <td class="px-4 py-3">
              @if($c->pivot->letter)
                <span class="inline-flex items-center gap-2">
                  <span class="rounded-full bg-blue-100 px-2 py-0.5 text-blue-700 text-xs font-semibold">
                    {{ $c->pivot->letter }}
                  </span>
                  <span class="text-slate-600 text-sm">
                    {{ $c->pivot->score ?? '—' }} / {{ number_format($c->pivot->grade_point,2) }}
                  </span>
                </span>
              @else
                <span class="text-slate-400">—</span>
              @endif
            </td>
            <td class="px-4 py-3">
              <div class="flex justify-end">
                <form method="post" action="{{ route('student.courses.drop',$c) }}"
                      onsubmit="return confirm('Drop course ini?')">
                  @csrf @method('DELETE')
                  <button class="rounded-lg bg-rose-600 px-3 py-1.5 text-white hover:bg-rose-700">
                    Drop
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="px-4 py-10 text-center text-slate-500">
              Belum ada course yang diambil.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="p-4">{{ $courses->links() }}</div>
  </div>
</x-student.layout>
