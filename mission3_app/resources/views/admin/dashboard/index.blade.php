<x-admin.layout title="Dashboard">
  {{-- Top stats --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <x-admin.stat-card 
        label="Total Students" 
        :value="$totalStudents" 
        icon="users" 
        accent="indigo" />

    <x-admin.stat-card 
        label="Total Courses" 
        :value="$totalCourses" 
        icon="layers" 
        accent="teal" />
  </div>

  {{-- Charts Section --}}
  <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    
    {{-- Students per Major --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md flex justify-center">
      <div class="w-full max-w-sm h-64">
        <canvas id="majorsChart"></canvas>
      </div>
    </div>

    {{-- Top 5 Popular Courses --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md flex justify-center">
      <div class="w-full max-w-sm h-64">
        <canvas id="coursesChart"></canvas>
      </div>
    </div>

    {{-- Grade Distribution --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md md:col-span-2 flex justify-center">
      <div class="w-full max-w-2xl h-64">
        <canvas id="gradesChart"></canvas>
      </div>
    </div>

  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // --- Students per Major ---
      const majorsData = @json($majorsData);
      new Chart(document.getElementById('majorsChart'), {
        type: 'pie',
        data: {
          labels: Object.keys(majorsData),
          datasets: [{
            data: Object.values(majorsData),
            backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6'],
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
            backgroundColor: [
              '#3b82f6', // biru
              '#10b981', // hijau
              '#f59e0b', // kuning
              '#ef4444', // merah
              '#8b5cf6'  // ungu
            ]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
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
            backgroundColor: '#10b981'
          }]
        },
        options: {
          responsive: true, maintainAspectRatio: false,
          scales: { y: { beginAtZero: true } }
        }
      });
    });
  </script>
</x-admin.layout>
