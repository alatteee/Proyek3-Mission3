<x-admin.layout :title="'Student Detail'">
  <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
    <div class="mb-6 flex items-center justify-between">
      <h3 class="text-xl font-semibold text-gray-800">
        {{ $student->full_name }}
      </h3>
      <div class="flex gap-2">
        <a href="{{ route('admin.students.edit', $student) }}"
           class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Edit</a>
        <a href="{{ route('admin.students.index') }}"
           class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Back</a>
      </div>
    </div>

    <dl class="grid gap-6 sm:grid-cols-2">
      <div>
        <dt class="text-sm text-gray-500">NIM</dt>
        <dd class="mt-1 font-medium text-gray-900">{{ $student->nim }}</dd>
      </div>
      <div>
        <dt class="text-sm text-gray-500">Entry Year</dt>
        <dd class="mt-1 font-medium text-gray-900">{{ $student->entry_year }}</dd>
      </div>
      <div>
        <dt class="text-sm text-gray-500">Major</dt>
        <dd class="mt-1 font-medium text-gray-900">{{ $student->major }}</dd>
      </div>
      <div>
        <dt class="text-sm text-gray-500">Phone</dt>
        <dd class="mt-1 font-medium text-gray-900">{{ $student->phone ?? '—' }}</dd>
      </div>

      {{-- Bagian akun user terkait (opsional, jika relasi sudah dibuat) --}}
      <div class="sm:col-span-2 border-t pt-4">
        <dt class="text-sm text-gray-500">User Account</dt>
        <dd class="mt-2 grid gap-2 sm:grid-cols-3">
          <div>
            <div class="text-xs text-gray-500">Username</div>
            <div class="font-medium text-gray-900">{{ $student->user->username ?? '—' }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500">Email</div>
            <div class="font-medium text-gray-900">{{ $student->user->email ?? '—' }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500">Role</div>
            <div class="font-medium text-gray-900">{{ $student->user->role ?? 'student' }}</div>
          </div>
        </dd>
      </div>
    </dl>
  </div>

  {{-- Card: Enrolled Courses --}}
  <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
    <div class="mb-4 flex items-center justify-between">
      <h3 class="text-lg font-semibold text-gray-800">
        Enrolled Courses ({{ $courses->total() }})
      </h3>

      {{-- Quick Enroll (opsional) --}}
      <form method="POST" action="{{ route('admin.students.enroll', $student) }}" class="flex items-center gap-2">
        @csrf
        <select name="course_id"
                class="rounded-lg border-gray-300 text-sm focus:border-blue-600 focus:ring-blue-600">
          <option value="">-- choose course --</option>
          @foreach ($availableCourses as $c)
            <option value="{{ $c->id }}">{{ $c->course_code }} — {{ $c->course_name }}</option>
          @endforeach
        </select>
        <button class="rounded-lg bg-blue-700 px-3 py-2 text-white text-sm hover:bg-blue-800">
          Enroll
        </button>
      </form>
    </div>

    @if ($courses->isEmpty())
      <p class="text-gray-500">Belum ada course yang diambil.</p>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50 text-gray-600">
            <tr>
              <th class="px-4 py-2 text-left">Code</th>
              <th class="px-4 py-2 text-left">Course</th>
              <th class="px-4 py-2 text-left">Credits</th>
              <th class="px-4 py-2 text-left">Semester</th>
              <th class="px-4 py-2 text-left">Enrolled At</th>
              <th class="px-4 py-2 text-left">Grade</th>
              <th class="px-4 py-2"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @foreach ($courses as $c)
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">{{ $c->course_code }}</td>
                <td class="px-4 py-2">{{ $c->course_name }}</td>
                <td class="px-4 py-2">{{ $c->credits }} SKS</td>
                <td class="px-4 py-2">{{ $c->semester ?? '—' }}</td>
                <td class="px-4 py-2">
                  {{ $c->pivot->enroll_date ? \Carbon\Carbon::parse($c->pivot->enroll_date)->format('d M Y') : '—' }}
                </td>
                <td class="px-4 py-2">
                  <form method="POST" action="{{ route('admin.students.grade', [$student, $c]) }}" class="flex items-center gap-2">
                    @csrf @method('PATCH')

                    {{-- Nilai angka 0–100 --}}
                    <input type="number" name="score" min="0" max="100"
                          value="{{ $c->pivot->score }}"
                          placeholder="score"
                          class="w-20 rounded border-slate-300 text-sm focus:border-blue-600 focus:ring-blue-600">

                    {{-- Nilai huruf (opsional: biarkan kosong untuk auto dari score) --}}
                    <select name="letter" class="rounded border-slate-300 text-sm focus:border-blue-600 focus:ring-blue-600">
                      <option value="">auto</option>
                      @foreach (['A','AB','B','BC','C','D','E'] as $L)
                        <option value="{{ $L }}" @selected($c->pivot->letter === $L)>{{ $L }}</option>
                      @endforeach
                    </select>

                    <button type="submit" class="rounded bg-blue-700 px-3 py-1.5 text-white text-sm hover:bg-blue-800">
                      Save
                    </button>
                  </form>

                  @if(!is_null($c->pivot->grade_point))
                    <div class="mt-1 text-xs text-slate-500">
                      GPA pt: {{ number_format($c->pivot->grade_point, 2) }}
                    </div>
                  @endif
                </td>
                <td class="px-4 py-2 text-right">
                  <form method="POST" action="{{ route('admin.students.unenroll', [$student, $c]) }}"
                        onsubmit="return confirm('Remove this course from student?')">
                    @csrf @method('DELETE')
                    <button class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">
                      Unenroll
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $courses->links() }}
      </div>
    @endif
  </div>

</x-admin.layout>
