<x-app-layout>
  <div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex items-end justify-between gap-4">
      <div>
        <h1 class="text-3xl font-extrabold">Checkout</h1>
        <p class="text-gray-300 mt-1">Confirm your items and enter shipping info.</p>
      </div>
      <a href="{{ route('cart.index') }}"
         class="rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-sm hover:bg-white/20">
        Back to Cart
      </a>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
      {{-- Items --}}
      <div class="md:col-span-2 space-y-4">
        @foreach($items as $row)
          @php
            $raw = $row['image'] ?? null;
            $img = $raw
              ? (\Illuminate\Support\Str::startsWith($raw, ['http://','https://']) ? $raw : asset(ltrim($raw,'/')))
              : asset('images/placeholder.jpg');
          @endphp

          <div class="flex items-center gap-4 rounded-xl border border-white/10 bg-white/5 p-4">
            <img src="{{ $img }}" alt="{{ $row['name'] }}" class="h-16 w-16 rounded object-cover">

            <div class="flex-1">
              <div class="font-semibold">{{ $row['name'] }}</div>
              <div class="text-sm text-gray-400 mt-1">
                Rs. {{ number_format($row['price'], 2) }} × {{ $row['qty'] }}
              </div>
            </div>

            <div class="w-28 text-right font-semibold">
              Rs. {{ number_format($row['line_total'], 2) }}
            </div>
          </div>
        @endforeach
      </div>

      {{-- Summary + form --}}
      <div>
        <div class="rounded-xl border border-white/10 bg-white/5 p-4">
          <div class="flex items-center justify-between">
            <span class="text-lg">Subtotal</span>
            <span class="text-xl font-semibold">Rs. {{ number_format($subtotal, 2) }}</span>
          </div>

          <form method="POST" action="{{ route('checkout.store') }}" class="mt-4 space-y-3">
            @csrf

            <label class="block">
              <span class="text-sm text-gray-300">Name</span>
              <input type="text" name="shipping_name" class="mt-1 w-full rounded-lg border border-white/20 bg-white/10 px-3 py-2" placeholder="Your name">
            </label>

            <label class="block">
              <span class="text-sm text-gray-300">Address</span>
              <textarea name="shipping_address" rows="3" class="mt-1 w-full rounded-lg border border-white/20 bg-white/10 px-3 py-2" placeholder="Street, City, Zip"></textarea>
            </label>

            <button class="w-full rounded-lg bg-red-600 px-4 py-2 font-semibold hover:bg-red-500">
              Place Order
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
