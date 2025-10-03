<div>
  <h2 class="text-lg font-semibold mb-3">Your Cart</h2>
  @forelse($items as $item)
    <div class="flex items-center justify-between py-2 border-b">
      <div>
        <div class="font-medium">{{ $item->product->name }}</div>
        <div class="text-sm text-gray-500">Qty: {{ $item->qty }}</div>
      </div>
      <div class="font-semibold">Rs. {{ number_format($item->qty * $item->unit_price,2) }}</div>
    </div>
  @empty
    <p class="text-gray-500">Cart is empty.</p>
  @endforelse
  <a href="{{ route('checkout.create') }}" class="mt-4 inline-block rounded-lg bg-black text-white px-4 py-2">Checkout</a>
</div>
