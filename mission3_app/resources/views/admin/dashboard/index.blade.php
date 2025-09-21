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

  {{-- Card: Students per Major --}}
  <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
    <h3 class="mb-4 text-lg font-semibold text-gray-800">Students per Major</h3>

    <div class="flex justify-center">
      <canvas id="majorsChart" class="w-full max-w-md h-64"></canvas>
    </div>
  </div>

  <script>
  document.addEventListener("DOMContentLoaded", function() {
      const majorsData = @json($majorsData); // pastikan ini array object: {"Informatika":5, "SI":2, ...}
      console.log("Majors Data:", majorsData); // debug dulu

      const ctx = document.getElementById('majorsChart').getContext('2d');
      new Chart(ctx, {
          type: 'pie',
          data: {
              labels: Object.keys(majorsData),
              datasets: [{
                  data: Object.values(majorsData),
                  backgroundColor: [
                      '#3b82f6', // blue
                      '#10b981', // green
                      '#f59e0b', // yellow
                      '#ef4444', // red
                      '#8b5cf6', // purple
                  ],
              }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false, // biar bisa diatur height-nya
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
      });
  });
  </script>


  {{-- Top 5 Course --}}
  <div class="mb-6">
    <h3 class="font-semibold text-gray-800 mb-2">Top 5 Popular Courses</h3>
    <ol class="list-decimal pl-6 text-gray-700">
      @foreach($popularCourses as $c)
        <li>{{ $c->course_name }} ({{ $c->students_count }} students)</li>
      @endforeach
    </ol>
  </div>

  {{-- Distribusi Nilai --}}
  <div class="mb-6">
    <h3 class="font-semibold text-gray-800 mb-2">Grade Distribution</h3>
    <ul class="list-disc pl-6 text-gray-700">
      @foreach($grades as $g)
        <li>{{ $g->letter }}: <strong>{{ $g->total }}</strong></li>
      @endforeach
    </ul>
  </div>
</x-admin.layout>
