<x-admin.layout title="Edit Student">
  <form method="POST" action="{{ route('admin.students.update', $student) }}" class="max-w-3xl">
    @csrf
    @method('PUT')

    <x-admin.form-card title="Account" subtitle="Perbarui data akun.">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-admin.field label="Username" for="username" :error="$errors->first('username')">
          <input id="username" name="username" type="text" autocomplete="username"
                 value="{{ old('username', $student->user->username) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Full Name" for="full_name" :error="$errors->first('full_name')">
          <input id="full_name" name="full_name" type="text" autocomplete="name"
                 value="{{ old('full_name', $student->user->full_name) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Email (optional)" for="email" :error="$errors->first('email')" class="md:col-span-2">
          <input id="email" name="email" type="email" autocomplete="email"
                 value="{{ old('email', $student->user->email) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Password (biarkan kosong jika tidak diganti)" for="password" :error="$errors->first('password')" class="md:col-span-2">
          <input id="password" name="password" type="password" autocomplete="new-password"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>
      </div>
    </x-admin.form-card>

    <div class="h-6"></div>

    <x-admin.form-card title="Student Data" subtitle="Perbarui profil mahasiswa.">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-admin.field label="Entry Year" for="entry_year" :error="$errors->first('entry_year')">
          <input id="entry_year" name="entry_year" type="number" inputmode="numeric" min="2000" max="2100"
                 value="{{ old('entry_year', $student->entry_year) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="NIM" for="nim" :error="$errors->first('nim')">
          <input id="nim" name="nim" type="text"
                 value="{{ old('nim', $student->nim) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Major" for="major" :error="$errors->first('major')">
          <input id="major" name="major" type="text"
                 value="{{ old('major', $student->major) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Phone" for="phone" :error="$errors->first('phone')">
          <input id="phone" name="phone" type="tel" autocomplete="tel"
                 value="{{ old('phone', $student->phone) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"/>
        </x-admin.field>

        <x-admin.field label="Address" for="address" :error="$errors->first('address')" class="md:col-span-2">
          <textarea id="address" name="address" rows="3"
                    class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $student->address) }}</textarea>
        </x-admin.field>
      </div>

      <x-admin.form-actions :cancel="route('admin.students.index')" saving="Update"/>
    </x-admin.form-card>
  </form>
</x-admin.layout>
