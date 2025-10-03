<x-guest-layout>
  <h1 class="text-xl font-extrabold">Sign in</h1>

  <x-validation-errors class="mt-4" />

  @session('status')
    <div class="mt-3 text-green-400 text-sm">{{ $value }}</div>
  @endsession

  <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
    @csrf
    <div>
      <x-label class="text-gray-300" for="email" value="Email" />
      <x-input id="email" class="block mt-1 w-full bg-white/5 border-white/10 text-white" type="email" name="email" required autofocus />
    </div>

    <div>
      <x-label class="text-gray-300" for="password" value="Password" />
      <x-input id="password" class="block mt-1 w-full bg-white/5 border-white/10 text-white" type="password" name="password" required autocomplete="current-password" />
    </div>

    <div class="flex items-center justify-between">
      <label class="inline-flex items-center gap-2 text-sm text-gray-300">
        <x-checkbox id="remember_me" name="remember" />
        <span>Remember me</span>
      </label>

      @if (Route::has('password.request'))
        <a class="text-sm text-gray-300 hover:text-white" href="{{ route('password.request') }}">Forgot?</a>
      @endif
    </div>

    <button class="w-full rounded-xl bg-white text-black py-2.5 font-semibold hover:bg-gray-100">Sign in</button>
  </form>

  <p class="mt-4 text-sm text-gray-300">No account?
    <a href="{{ route('register') }}" class="underline hover:text-white">Create one</a>
  </p>
</x-guest-layout>
