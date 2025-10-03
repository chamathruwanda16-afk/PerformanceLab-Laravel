<nav x-data="{ open:false }" class="sticky top-0 z-50 bg-[#0a0d11]/95 backdrop-blur border-b border-white/10">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex h-16 items-center justify-between">
      <a href="{{ route('home') }}" class="flex items-center gap-3">
        {{-- TODO: replace with real logo image --}}
        <div class="h-7 w-36 flex items-center justify-center rounded bg-white text-black font-extrabold tracking-widest">
          PERF
        </div>
        <span class="sr-only">Performance Lab</span>
      </a>

      <div class="hidden sm:flex items-center gap-8">
        <a href="{{ route('home') }}" class="text-sm hover:text-white {{ request()->routeIs('home') ? 'text-white' : 'text-gray-300' }}">Home</a>
        <a href="{{ route('products.index') }}" class="text-sm hover:text-white {{ request()->routeIs('products.*') ? 'text-white' : 'text-gray-300' }}">Products</a>
        <a href="#" class="text-sm text-gray-300 hover:text-white">About</a>
      </div>

      <div class="hidden sm:flex items-center gap-3">
        @auth
          <a href="{{ route('dashboard') }}" class="rounded-lg border border-white/10 px-3 py-1.5 text-sm hover:bg-white/5">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-lg bg-white text-black px-3 py-1.5 text-sm font-semibold hover:bg-gray-100">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="text-sm text-gray-300 hover:text-white">Login</a>
          <a href="{{ route('register') }}" class="rounded-lg bg-white text-black px-3 py-1.5 text-sm font-semibold hover:bg-gray-100">Register</a>
        @endauth
      </div>

      <button @click="open=!open" class="sm:hidden p-2 rounded hover:bg-white/5">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>
  </div>

  <div x-show="open" x-cloak class="sm:hidden border-t border-white/10">
    <div class="px-6 py-4 space-y-3">
      <a href="{{ route('home') }}" class="block text-gray-300 hover:text-white">Home</a>
      <a href="{{ route('products.index') }}" class="block text-gray-300 hover:text-white">Products</a>
      <a href="#" class="block text-gray-300 hover:text-white">About</a>
      <div class="pt-3 border-t border-white/10">
        @auth
          <a href="{{ route('dashboard') }}" class="block text-gray-300 hover:text-white">Dashboard</a>
          <form method="POST" action="{{ route('logout') }}" class="mt-2">@csrf
            <button class="w-full text-left text-gray-300 hover:text-white">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="block text-gray-300 hover:text-white">Login</a>
          <a href="{{ route('register') }}" class="block text-gray-300 hover:text-white">Register</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
