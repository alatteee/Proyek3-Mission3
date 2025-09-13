<x-admin.layout :title="'Course Detail'">
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
</x-admin.layout>
