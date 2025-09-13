<x-layouts.auth title="Register">
  <h1 class="text-2xl font-bold text-slate-800 mb-6">Create your account</h1>

  <form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-medium text-slate-700">Name</label>
      <input type="text" name="name" required
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm
               focus:border-blue-600 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700">Email</label>
      <input type="email" name="email" required
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm
               focus:border-blue-600 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700">Password</label>
      <input type="password" name="password" required
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm
               focus:border-blue-600 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700">Confirm Password</label>
      <input type="password" name="password_confirmation" required
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm
               focus:border-blue-600 focus:ring-blue-600">
    </div>

    <button type="submit"
      class="w-full rounded-lg bg-blue-700 px-4 py-2 text-white font-semibold
             hover:bg-blue-800 focus-visible:outline-none focus-visible:ring-2
             focus-visible:ring-blue-500 shadow">
      Register
    </button>

    <p class="text-center text-sm text-slate-600">
      Already have an account?
      <a href="{{ route('login') }}" class="text-blue-700 font-medium hover:text-blue-800 hover:underline">
        Sign in
      </a>
    </p>
  </form>
</x-layouts.auth>
