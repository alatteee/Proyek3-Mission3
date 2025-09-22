<x-admin.layout title="Dashboard">

  {{-- Welcome Banner --}}
  <div class="rounded-2xl bg-gradient-to-r from-indigo-400/80 to-purple-400/80 p-6 text-white shadow-sm mb-6">
    <h2 class="text-2xl font-bold">Hi, {{ auth()->user()->name ?? 'Admin' }} 👋</h2>
    <p class="opacity-90 mt-1">Welcome back to the Admin Dashboard</p>
  </div>

  {{-- Overview Cards --}}
  <div class="grid gap-6 md:grid-cols-2 mb-6">
    <div class="rounded-2xl bg-emerald-100 p-5 text-emerald-700 shadow-sm">
      <div class="text-4xl font-bold">{{ $totalStudents }}</div>
      <div class="mt-2 text-sm font-medium opacity-80">Total Students</div>
    </div>
    <div class="rounded-2xl bg-sky-100 p-5 text-sky-700 shadow-sm">
      <div class="text-4xl font-bold">{{ $totalCourses }}</div>
      <div class="mt-2 text-sm font-medium opacity-80">Total Courses</div>
    </div>
  </div>

  {{-- Charts Section --}}
  <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    
    {{-- Students per Major --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
      <h3 class="mb-4 text-lg font-semibold text-slate-800">Students per Major</h3>
      <div class="w-full max-w-sm h-64 mx-auto">
        <canvas id="majorsChart"></canvas>
      </div>
    </div>

    {{-- Top 5 Popular Courses --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
      <h3 class="mb-4 text-lg font-semibold text-slate-800">Top 5 Popular Courses</h3>
      <div class="w-full max-w-sm h-64 mx-auto">
        <canvas id="coursesChart"></canvas>
      </div>
    </div>

    {{-- Grade Distribution --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md md:col-span-2">
      <h3 class="mb-4 text-lg font-semibold text-slate-800">Grade Distribution</h3>
      <div class="w-full max-w-2xl h-64 mx-auto">
        <canvas id="gradesChart"></canvas>
      </div>
    </div>

  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // soft pastel colors
      const pastelColors = ['#93c5fd','#6ee7b7','#fde68a','#fca5a5','#c4b5fd'];

      // --- Students per Major ---
      const majorsData = @json($majorsData);
      new Chart(document.getElementById('majorsChart'), {
        type: 'pie',
        data: {
          labels: Object.keys(majorsData),
          datasets: [{
            data: Object.values(majorsData),
            backgroundColor: pastelColors,
          }]
        },
        options: { responsive: true, maintainAspectRatio: false }
      });

      // --- Top 5 Popular Courses ---
      const coursesData = @json($popularCourses);
      new Chart(document.getElementById('coursesChart').getContext('2d'), {
        type: 'pie',
        data: {
          labels: coursesData.map(c => c.course_name),
          datasets: [{
            data: coursesData.map(c => c.students_count),
            backgroundColor: pastelColors
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { position: 'bottom' } }
        }
      });

      // --- Grade Distribution ---
      const gradesData = @json($grades);
      new Chart(document.getElementById('gradesChart'), {
        type: 'bar',
        data: {
          labels: gradesData.map(g => g.letter),
          datasets: [{
            label: 'Students',
            data: gradesData.map(g => g.total),
            backgroundColor: '#6ee7b7'
          }]
        },
        options: {
          responsive: true, 
          maintainAspectRatio: false,
          scales: { y: { beginAtZero: true } }
        }
      });
    });
  </script>
</x-admin.layout>
