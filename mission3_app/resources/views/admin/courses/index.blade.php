<x-admin.layout :title="'Courses'">  
  @if(session('ok'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
      {{ session('ok') }}
    </div>
  @endif

  <div class="rounded-2xl border border-gray-200 bg-white shadow-md">
    <div class="flex items-center justify-between p-4">
      <a href="{{ route('admin.courses.create') }}"
         class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-500">+ New Course</a>

      <form method="get" class="hidden md:block">
        <input name="q" value="{{ request('q') }}" placeholder="Search courses..."
               class="rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-700">
          <tr>
            <th class="px-4 py-3 text-left font-semibold">Code</th>
            <th class="px-4 py-3 text-left font-semibold">Name</th>
            <th class="px-4 py-3 text-left font-semibold">Credits</th>
            <th class="px-4 py-3 text-left font-semibold">Semester</th>
            <th class="px-4 py-3 text-right font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-gray-800">
        @forelse($courses as $c)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3 font-mono">{{ $c->course_code }}</td>
            <td class="px-4 py-3">{{ $c->course_name }}</td>
            <td class="px-4 py-3">
              <span class="rounded-full bg-blue-100 px-2 py-0.5 text-blue-700">{{ $c->credits }} SKS</span>
            </td>
            <td class="px-4 py-3">{{ $c->semester ?? '—' }}</td>
            <td class="px-4 py-3">
              <div class="flex justify-end gap-2">
                <a href="{{ route('admin.courses.show', $c) }}"
                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Detail</a>

                <a href="{{ route('admin.courses.edit',$c) }}"
                   class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Edit</a>

                <form method="post" action="{{ route('admin.courses.destroy',$c) }}"
                      onsubmit="return confirm('Hapus course ini?')">
                  @csrf @method('DELETE')
                  <button class="rounded-lg bg-red-600 px-3 py-1.5 text-white hover:bg-red-500">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada course.</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div class="p-4">{{ $courses->links() }}</div>
  </div>
</x-admin.layout>
