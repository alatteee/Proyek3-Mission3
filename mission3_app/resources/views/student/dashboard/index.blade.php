<x-student.layout title="Dashboard">

  {{-- Welcome Banner --}}
  <div class="rounded-2xl bg-gradient-to-r from-indigo-400/80 to-purple-400/80 
              p-6 text-white shadow-sm mb-8">
    <h2 class="text-2xl font-semibold">
      Hi, {{ $student->full_name ?? $user->full_name ?? 'Student' }} 👋
    </h2>
    <p class="mt-2 text-sm opacity-90">
      NIM: <span class="font-medium">{{ $student->nim ?? '—' }}</span> · 
      Major: <span class="font-medium">{{ $student->major ?? '—' }}</span> · 
      Entry Year: <span class="font-medium">{{ $student->entry_year ?? '—' }}</span>
    </p>
  </div>


  {{-- Cards Statistik Utama --}}
  <div class="grid gap-6 md:grid-cols-3">
    <div class="rounded-2xl bg-emerald-100 p-5 text-emerald-800 shadow-sm">
      <div class="text-4xl font-bold leading-none">{{ $totalCourses }}</div>
      <div class="mt-2 text-sm/5 opacity-90">All Courses</div>
    </div>
    <div class="rounded-2xl bg-indigo-100 p-5 text-indigo-800 shadow-sm">
      <div class="text-4xl font-bold leading-none">{{ $enrolledCount }}</div>
      <div class="mt-2 text-sm/5 opacity-90">My Courses</div>
    </div>
    <div class="rounded-2xl bg-rose-100 p-5 text-rose-800 shadow-sm">
      <div class="text-4xl font-bold leading-none">{{ $availableToTake }}</div>
      <div class="mt-2 text-sm/5 opacity-90">Available</div>
    </div>
  </div>

  {{-- SKS & GPA --}}
  <div class="mt-6 grid gap-6 md:grid-cols-2">
    <div class="rounded-2xl bg-teal-100 p-5 text-teal-800 shadow-sm">
      <div class="text-4xl font-bold leading-none">{{ $totalSks }}</div>
      <div class="mt-2 text-sm/5 opacity-90">Total SKS Taken</div>
    </div>
    <div class="rounded-2xl p-5 shadow-sm
         @if($gpa >= 3) bg-emerald-100 text-emerald-800
         @elseif($gpa >= 2) bg-amber-100 text-amber-800
         @else bg-rose-100 text-rose-800 @endif">
      <div class="text-4xl font-bold leading-none">
        {{ $gpa ? number_format($gpa,2) : '—' }}
      </div>
      <div class="mt-2 text-sm/5 opacity-90">Current GPA</div>
    </div>
  </div>

    {{-- Grade Distribution --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm mt-10">
      <h3 class="mb-4 text-lg font-semibold text-gray-800">Grade Distribution</h3>
      <div class="flex justify-center">
        <div class="w-64 h-64">
          <canvas id="studentGradesChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Async Demo --}}
  <div class="mt-6">
    <button id="asyncDemoBtn"
            class="rounded-lg bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-500">
      Coba Async Demo
    </button>
    <div id="asyncResult" class="mt-2 text-slate-600"></div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const gradesData = @json($studentGrades);

      if (gradesData && Object.keys(gradesData).length > 0) {
        new Chart(document.getElementById('studentGradesChart').getContext('2d'), {
          type: 'pie',
          data: {
            labels: Object.keys(gradesData),
            datasets: [{
              data: Object.values(gradesData),
              backgroundColor: [
                  '#93c5fd', // soft blue (A)
                  '#6ee7b7', // soft green (AB)
                  '#fde68a', // soft amber/yellow (B)
                  '#fca5a5', // soft red (BC)
                  '#d8b4fe'  // soft purple (cadangan kalau ada grade lain)
                ],
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
          }
        });
      }
    });
  </script>

</x-student.layout>
