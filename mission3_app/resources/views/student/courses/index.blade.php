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

  <div class="mb-4 flex items-center gap-3">
    <button id="btn-enroll-selected"
            class="rounded-lg bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
      Enroll Selected
    </button>
    <span class="ml-3 text-sm text-slate-600">
      Total SKS: <strong id="total-sks">0</strong>
    </span>

    <!-- Filter Semester -->
    <select id="studentFilterSemester" 
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm ml-6">
      <option value="">All Semesters</option>
      <option value="Ganjil">Ganjil</option>
      <option value="Genap">Genap</option>
    </select>

    <!-- Filter Credits -->
    <select id="studentFilterCredits" 
            class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
      <option value="">All Credits</option>
      <option value="2">2 SKS</option>
      <option value="3">3 SKS</option>
      <option value="4">4 SKS</option>
    </select>

    <!-- Search box -->
    <input id="studentSearchInput" type="text" 
          placeholder="Search code/name…" 
          class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
  </div>


  <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="min-w-full text-sm">
      <thead class="bg-slate-50 text-slate-700">
        <tr>
          <th class="px-4 py-3 text-center">
            <input type="checkbox" id="checkAll"
                  class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
          </th>
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
            <td class="px-4 py-3 text-center">
              <input type="checkbox"
                    class="js-course-check rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                    value="{{ $c->id }}"
                    data-sks="{{ $c->credits }}"
                    @if(in_array($c->id, $enrolledIds)) disabled @endif>
            </td>
            <td class="px-4 py-3 font-mono">{{ $c->course_code }}</td>
            <td class="px-4 py-3">{{ $c->course_name }}</td>
            <td class="px-4 py-3">{{ $c->credits }} SKS</td>
            <td class="px-4 py-3">{{ $c->semester ?? '—' }}</td>
            <td class="px-4 py-3">
              <div class="flex justify-end">
                @php $mine = isset($my) ? $my->get($c->id) : null; @endphp

                @if(in_array($c->id, $enrolledIds))
                  <span class="rounded-lg bg-emerald-50 px-3 py-1.5 text-emerald-700">
                    Enrolled{{ $mine && $mine->pivot->letter ? ' ('.$mine->pivot->letter.')' : '' }}
                  </span>
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
  <script>
    // data mahasiswa yang login
    window.studentData = @json($studentData);

    // daftar semua course
    window.coursesData = @json($coursesData);

    console.log("Current Student:", window.studentData);
    console.log("Courses:", window.coursesData);
  </script>

  <script>
    window.bulkEnrollUrl = "{{ route('student.courses.bulk-enroll') }}";
  </script>

</x-student.layout>
