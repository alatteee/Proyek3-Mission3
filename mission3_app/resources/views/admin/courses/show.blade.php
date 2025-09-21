<x-admin.layout :title="'Course Detail'">
  {{-- Flash message --}}
  @if(session('ok'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
      {{ session('ok') }}
    </div>
  @endif
  {{-- Card: Course Detail --}}
  <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
    <div class="mb-6 flex items-center justify-between">
      <h3 class="text-xl font-semibold text-gray-800">
        {{ $course->course_code }} — {{ $course->course_name }}
      </h3>
      <div class="flex gap-2">
        <a href="{{ route('admin.courses.edit', $course) }}"
           class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Edit</a>
        <a href="{{ route('admin.courses.index') }}"
           class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Back</a>
      </div>
    </div>

    <dl class="grid gap-6 sm:grid-cols-2">
      <div>
        <dt class="text-sm text-gray-500">Course Code</dt>
        <dd class="mt-1 font-medium text-gray-900">{{ $course->course_code }}</dd>
      </div>
      <div>
        <dt class="text-sm text-gray-500">Credits</dt>
        <dd class="mt-1">
          <span class="rounded-full bg-blue-100 px-2 py-0.5 text-sm font-medium text-blue-700">
            {{ $course->credits }} SKS
          </span>
        </dd>
      </div>
      <div>
        <dt class="text-sm text-gray-500">Semester</dt>
        <dd class="mt-1 font-medium text-gray-900">{{ $course->semester ?? '—' }}</dd>
      </div>
      <div class="sm:col-span-2">
        <dt class="text-sm text-gray-500">Description</dt>
        <dd class="mt-1 whitespace-pre-line font-medium text-gray-900">
          {{ $course->description ?? '—' }}
        </dd>
      </div>
    </dl>
  </div>

  {{-- Card: Enrolled Students --}}
  <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
    <h3 class="mb-4 text-lg font-semibold text-gray-800">
      Enrolled Students ({{ $students->total() }})
    </h3>

    @if ($students->isEmpty())
      <p class="text-gray-500">Belum ada mahasiswa yang terdaftar.</p>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50 text-gray-600">
            <tr>
              <th class="px-4 py-2 text-left">Name</th>
              <th class="px-4 py-2 text-left">NIM</th>
              <th class="px-4 py-2 text-left">Major</th>
              <th class="px-4 py-2 text-left">Entry Year</th>
              <th class="px-4 py-2 text-left">Enrolled At</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @foreach ($students as $s)
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">{{ $s->user->full_name ?? $s->user->username ?? '—' }}</td>
                <td class="px-4 py-2">{{ $s->nim ?? '—' }}</td>
                <td class="px-4 py-2">{{ $s->major ?? '—' }}</td>
                <td class="px-4 py-2">{{ $s->entry_year ?? '—' }}</td>
                <td class="px-4 py-2">
                  {{ $s->pivot->enroll_date ? \Carbon\Carbon::parse($s->pivot->enroll_date)->format('d M Y') : '—' }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $students->links() }}
      </div>
    @endif
  </div>


  {{-- Card: Available Students (bulk enroll) --}}
  <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
    <h3 class="mb-4 text-lg font-semibold text-gray-800">
      Available Students
    </h3>

    @if ($availableStudents->isEmpty())
      <p class="text-gray-500">All students are already enrolled in this course.</p>
    @else
      <form method="POST" action="{{ route('admin.courses.bulk-enroll', $course) }}">
        @csrf
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
              <tr>
                <th class="px-4 py-2 text-center">
                  <input type="checkbox" id="checkAllAvailable"
                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                </th>
                <th class="px-4 py-2 text-left">NIM</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Major</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @foreach ($availableStudents as $s)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-2 text-center">
                    <input type="checkbox" name="student_ids[]" value="{{ $s->student_id }}"
                          class="available-check rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                  </td>
                  <td class="px-4 py-2 font-mono">{{ $s->nim }}</td>
                  <td class="px-4 py-2">{{ $s->user->full_name }}</td>
                  <td class="px-4 py-2">{{ $s->major }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mt-4">
          <button type="submit"
                  class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-500">
            Enroll Selected
          </button>
        </div>
      </form>
    @endif
  </div>
</x-admin.layout>
