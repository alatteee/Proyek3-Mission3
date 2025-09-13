<x-admin.layout title="Edit Course">
  <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="max-w-3xl">
    @csrf
    @method('PUT')

    <x-admin.form-card title="Course Details" subtitle="Perbarui informasi mata kuliah.">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-admin.field label="Course Code" for="course_code" :error="$errors->first('course_code')">
             <input id="course_code" name="course_code" type="text" required
                value="{{ old('course_code', $course->course_code) }}"
                class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Credits (SKS)" for="credits" :error="$errors->first('credits')">
          <input id="credits" name="credits" type="number" min="0" required
                 value="{{ old('credits', $course->credits) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Course Name" for="course_name" :error="$errors->first('course_name')">
            <input id="course_name" name="course_name" type="text" required
                    value="{{ old('course_name', $course->course_name) }}"
                    class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Semester" for="semester" :error="$errors->first('semester')">
          <select id="semester" name="semester"
                  class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            @php $sem = old('semester', $course->semester); @endphp
            <option value="Ganjil" @selected($sem==='Ganjil')>Ganjil</option>
            <option value="Genap"  @selected($sem==='Genap')>Genap</option>
          </select>
        </x-admin.field>

        <x-admin.field label="Description" for="description" :error="$errors->first('description')" class="md:col-span-2">
          <textarea id="description" name="description" rows="4"
                    class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $course->description) }}</textarea>
        </x-admin.field>
      </div>

      <x-admin.form-actions :cancel="route('admin.courses.index')" saving="Update Course"/>
    </x-admin.form-card>
  </form>
</x-admin.layout>
