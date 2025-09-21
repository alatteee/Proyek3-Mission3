<x-admin.layout title="Add New Course">
  <form method="POST" action="{{ route('admin.courses.store') }}" class="max-w-3xl" data-validate novalidate>
    @csrf
    <x-admin.form-card title="Course Details" subtitle="Lengkapi informasi mata kuliah.">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-admin.field label="Course Code" for="course_code" :error="$errors->first('course_code')">
          <input id="course_code" name="course_code" type="text" required
                 value="{{ old('course_code') }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Credits (SKS)" for="credits" :error="$errors->first('credits')">
          <input id="credits" name="credits" type="number" min="0" required
                 value="{{ old('credits') }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Course Name" for="course_name" :error="$errors->first('course_name')" class="md:col-span-2">
          <input id="course_name" name="course_name" type="text" required
                 value="{{ old('course_name') }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Semester" for="semester" :error="$errors->first('semester')">
          <select id="semester" name="semester"
                  class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="" {{ old('semester') ? '' : 'selected' }}>—</option>
            <option value="Ganjil"  @selected(old('semester')==='Ganjil')>Ganjil</option>
            <option value="Genap"   @selected(old('semester')==='Genap')>Genap</option>
          </select>
        </x-admin.field>

        <x-admin.field label="Description" for="description" :error="$errors->first('description')" class="md:col-span-2">
          <textarea id="description" name="description" rows="4"
                    class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
        </x-admin.field>
      </div>

      <x-admin.form-actions :cancel="route('admin.courses.index')" saving="Create Course"/>
    </x-admin.form-card>
  </form>
</x-admin.layout>
