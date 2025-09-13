<x-student.layout title="Browse Courses">
  @if(session('ok'))
    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">
      {{ session('ok') }}
    </div>
  @endif

  <div class="mb-4 flex items-center justify-between">
    <h2 class="text-xl font-semibold text-slate-900">All Courses</h2>
    <form method="get">
      <input name="q" value="{{ $q }}" placeholder="Search code/name..."
             class="rounded-xl border border-slate-300 px-3 py-2 text-sm
                    focus:border-emerald-500 focus:ring-emerald-500 focus:outline-none">
    </form>
  </div>

  <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-700">
        <tr>
          <th class="px-4 py-3 text-left font-semibold">Code</th>
          <th class="px-4 py-3 text-left font-semibold">Name</th>
          <th class="px-4 py-3 text-left font-semibold">Credits</th>
          <th class="px-4 py-3 text-left font-semibold">Semester</th>
          <th class="px-4 py-3 text-right font-semibold">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-200 text-slate-900">
        @foreach($courses as $c)
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 font-mono">{{ $c->course_code }}</td>
            <td class="px-4 py-3">{{ $c->course_name }}</td>
            <td class="px-4 py-3">{{ $c->credits }} SKS</td>
            <td class="px-4 py-3">{{ $c->semester }}</td>
            <td class="px-4 py-3">
              <div class="flex justify-end">
                @if(in_array($c->id, $enrolledIds))
                  <span class="rounded-lg bg-emerald-50 px-3 py-1.5 text-emerald-700">Enrolled</span>
                @else
                  <form method="post" action="{{ route('student.courses.enroll',$c) }}">
                    @csrf
                    <button class="rounded-lg bg-emerald-600 px-3 py-1.5 text-white hover:bg-emerald-700">
                      Enroll
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="p-4">{{ $courses->links() }}</div>
  </div>
</x-student.layout>
