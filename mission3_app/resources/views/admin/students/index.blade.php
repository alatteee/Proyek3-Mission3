<x-admin.layout :title="'Students'">  
  <x-slot name="header"><h2 class="font-semibold text-xl text-gray-900">Students</h2></x-slot>

  <div class="flex">

    <main class="flex-1 p-6">
      @if(session('ok'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
          {{ session('ok') }}
        </div>
      @endif

      <div class="rounded-2xl border border-gray-200 bg-white shadow-md">
        <div class="flex items-center justify-between p-4">
          <a href="{{ route('admin.students.create') }}"
            class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-500">+ New Student</a>

          <div class="flex items-center gap-3">
            <!-- Dropdown filter major -->
            <select id="filterMajor" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
              <option value="">All Majors</option>
              <option value="Informatika">Informatika</option>
              <option value="Sistem Informasi">Sistem Informasi</option>
              <option value="Manajemen">Manajemen</option>
              <option value="Akuntansi">Akuntansi</option>
            </select>

            <!-- Search box -->
            <input id="searchInput" type="text" 
                  placeholder="Search" 
                  class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
          </div>
        </div>


        <div class="overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
              <tr>
                <th class="px-4 py-3 text-left">NIM</th>
                <th class="px-4 py-3 text-left">Username</th>
                <th class="px-4 py-3 text-left">Full Name</th>
                <th class="px-4 py-3 text-left">Entry Year</th>
                <th class="px-4 py-3 text-left">Major</th>
                <th class="px-4 py-3 text-left">Phone</th>
                <th class="px-4 py-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-800">
              @forelse($students as $s)
                <tr class="hover:bg-gray-50">
                  <td class="px-4 py-3 font-mono">{{ $s->nim }}</td>
                  <td class="px-4 py-3">{{ $s->user->username }}</td>
                  <td class="px-4 py-3">{{ $s->user->full_name }}</td>
                  <td class="px-4 py-3">{{ $s->entry_year }}</td>
                  <td class="px-4 py-3">{{ $s->major }}</td>
                  <td class="px-4 py-3">{{ $s->phone }}</td>
                  <td class="px-4 py-3">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.students.show', $s) }}"
                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Detail</a>

                      <a href="{{ route('admin.students.edit', $s) }}"
                         class="rounded-lg border border-gray-300 px-3 py-1.5 text-gray-700 hover:bg-gray-100">Edit</a>
                      <form method="post" action="{{ route('admin.students.destroy', $s) }}"
                            data-confirm
                            data-name="{{ $s->user->full_name }}"
                            data-nim="{{ $s->nim }}">
                        @csrf @method('DELETE')
                        <button class="rounded-lg bg-red-600 px-3 py-1.5 text-white hover:bg-red-500">Delete</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">No data</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="p-4">{{ $students->links() }}</div>
      </div>
    </main>
  </div>
  <script>
    window.studentsData = @json($studentsData);
    console.log("Students (Admin):", window.studentsData);
  </script>

</x-admin.layout>
