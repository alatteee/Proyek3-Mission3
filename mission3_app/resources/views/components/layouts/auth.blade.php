@props(['title' => 'Auth'])

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title }} — Academia</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen antialiased
             bg-gradient-to-br from-sky-50 via-indigo-50 to-blue-100">

  <main class="min-h-screen flex items-center justify-center p-4">
    <section
      class="w-full max-w-4xl grid md:grid-cols-2 rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 overflow-hidden">

      {{-- Kiri: form --}}
      <div class="p-8 md:p-10">
        {{ $slot }}
      </div>

      {{-- Kanan: brand panel (kontras lembut) --}}
      <div class="relative hidden md:flex items-center justify-center">
        <div class="absolute inset-0 bg-gradient-to-br
                    from-blue-600 via-indigo-500 to-sky-500 opacity-90"></div>
      
        <div class="absolute inset-0 backdrop-blur-[1px]"></div>

        <div class="relative text-white">
          <div class="text-2xl font-bold drop-shadow-sm">Academia</div>
        </div>
      </div>

    </section>
  </main>

</body>
</html>
