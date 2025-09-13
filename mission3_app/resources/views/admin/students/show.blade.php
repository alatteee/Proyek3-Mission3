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
</x-admin.layout>
