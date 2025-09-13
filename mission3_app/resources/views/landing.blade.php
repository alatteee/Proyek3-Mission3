<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Academia — Learn anything with ease</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased bg-gradient-to-br from-sky-50 via-indigo-50 to-blue-100">

  {{-- Hero --}}
    <main class="max-w-6xl mx-auto px-4 min-h-screen flex items-center justify-center">
    <div class="text-center max-w-2xl">
      
      <p class="text-sm font-medium text-slate-600">For everyone.</p>

      <h1 class="mt-4 text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
        Learn
        <span class="relative inline-block">
          <span class="relative z-10">better</span>
          <span class="absolute inset-0 -rotate-2 rounded-full bg-sky-200/60 scale-110 translate-y-3 -z-0"></span>
        </span>
        as easily
      </h1>

      <h2 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
        as sending a message.
      </h2>

      <p class="mt-5 text-slate-600">
        Kelola course, daftar, dan belajar tanpa ribet. Academia membantu kampus
        menyederhanakan proses enrollment.
      </p>

      <div class="mt-8 flex gap-3 justify-center">
        <a href="{{ route('register') }}"
           class="rounded-xl bg-blue-700 px-5 py-3 text-white font-semibold hover:bg-blue-800">
          Get started
        </a>
        <a href="{{ route('login') }}"
           class="rounded-xl border border-slate-300 px-5 py-3 text-slate-700 hover:bg-white/60">
          Sign in
        </a>
      </div>

    </div>
  </main>

  {{-- Footer --}}
  <footer class="py-10 text-center text-sm text-slate-500">
    © {{ date('Y') }} Academia. All rights reserved.
  </footer>

</body>
</html>
