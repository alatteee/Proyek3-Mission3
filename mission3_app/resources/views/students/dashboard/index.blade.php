<x-student.layout title="Dashboard">
  <div class="grid gap-6 md:grid-cols-3">
    <div class="rounded-2xl bg-emerald-600 p-5 text-white shadow-sm">
      <div class="text-4xl font-bold leading-none">{{ $totalCourses }}</div>
      <div class="mt-2 text-sm/5 opacity-90">All Courses</div>
    </div>
    <div class="rounded-2xl bg-emerald-600 p-5 text-white shadow-sm">
      <div class="text-4xl font-bold leading-none">{{ $enrolledCount }}</div>
      <div class="mt-2 text-sm/5 opacity-90">My Courses</div>
    </div>
    <div class="rounded-2xl bg-emerald-600 p-5 text-white shadow-sm">
      <div class="text-4xl font-bold leading-none">{{ $availableToTake }}</div>
      <div class="mt-2 text-sm/5 opacity-90">Available</div>
    </div>
  </div>

  <div class="mt-8 grid gap-6 md:grid-cols-2">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
      <div class="text-xs font-medium text-slate-500">Welcome</div>
      <div class="mt-1 text-xl font-semibold text-slate-900">
        {{ $student->full_name ?? $user->full_name ?? 'Student' }}
      </div>
      <dl class="mt-4 grid gap-y-2 text-sm text-slate-700">
        <div class="flex justify-between"><dt class="text-slate-500">NIM</dt><dd class="font-medium">{{ $student->nim ?? '—' }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500">Major</dt><dd class="font-medium">{{ $student->major ?? '—' }}</dd></div>
        <div class="flex justify-between"><dt class="text-slate-500">Entry Year</dt><dd class="font-medium">{{ $student->entry_year ?? '—' }}</dd></div>
      </dl>
    </div>
  </div>
</x-student.layout>

