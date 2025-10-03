<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>{{ config('app.name', 'Performance Lab') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />

  <!-- Vite / Mix -->
  @vite(['resources/css/app.css','resources/js/app.js'])
   @livewireStyles
</head>
<body class="antialiased bg-[#0a0d11] text-white">
  @include('navigation-menu')

  <!-- Page Content -->
  <main class="min-h-screen">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <footer class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-10 grid sm:grid-cols-3 gap-6 text-sm text-gray-300">
      <div>
        <div class="text-lg font-extrabold tracking-widest">PERFORMANCE</div>
        <p class="mt-2 text-gray-400">Premium JDM parts. Engineered for power.</p>
      </div>
      <div>
        <div class="font-semibold text-white">Links</div>
        <ul class="mt-2 space-y-2">
          <li><a class="hover:text-white" href="{{ route('home') }}">Home</a></li>
          <li><a class="hover:text-white" href="{{ route('products.index') }}">Products</a></li>
          @auth
            <li><a class="hover:text-white" href="{{ route('dashboard') }}">Dashboard</a></li>
          @endauth
        </ul>
      </div>
      <div class="sm:text-right">
        <div>© {{ date('Y') }} Performance Lab</div>
      </div>
    </div>
  </footer>

  @stack('modals')
  @livewireScripts
</body>
</html>
