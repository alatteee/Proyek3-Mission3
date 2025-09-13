<x-layouts.auth title="Login">
  <h1 class="text-2xl font-bold text-slate-800 mb-6">Welcome back</h1>

  <form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-medium text-slate-700">Email</label>
      <input type="email" name="email" required autofocus
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm
               focus:border-blue-600 focus:ring-blue-600">
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-700">Password</label>
      <input type="password" name="password" required
        class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm
               focus:border-blue-600 focus:ring-blue-600">
    </div>

    <div class="flex items-center justify-between text-sm">
      <label class="flex items-center gap-2">
        <input type="checkbox" name="remember"
          class="rounded border-slate-300 text-blue-700 focus:ring-blue-600">
        Remember me
      </label>
      <a href="{{ route('password.request') }}" class="text-blue-700 hover:text-blue-800 hover:underline">
        Forgot password?
      </a>
    </div>

    <button type="submit"
      class="w-full rounded-lg bg-blue-700 px-4 py-2 text-white font-semibold
             hover:bg-blue-800 focus-visible:outline-none focus-visible:ring-2
             focus-visible:ring-blue-500 shadow">
      Sign in
    </button>

    <p class="text-center text-sm text-slate-600">
      Don't have an account?
      <a href="{{ route('register') }}" class="text-blue-700 font-medium hover:text-blue-800 hover:underline">
        Sign up
      </a>
    </p>
  </form>
</x-layouts.auth>
