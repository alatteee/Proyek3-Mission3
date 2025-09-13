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
</x-admin.layout>
