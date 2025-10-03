<x-app-layout>
  {{-- HERO --}}
  <section class="bg-[#0b0e12]">
    <div class="max-w-7xl mx-auto px-6 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 items-center">
      <div>
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">Unleash<br/>Your Machine</h1>
        <p class="mt-5 text-gray-300 max-w-xl">Premium JDM performance parts. Engineered for power, built for precision.</p>
        <div class="mt-8">
          <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold hover:bg-red-500">
            Shop Now
          </a>
        </div>
      </div>
      <div class="relative">
        <div class="aspect-[4/3] w-full rounded-3xl bg-gradient-to-br from-white/10 to-white/0 border border-white/10 flex items-center justify-center overflow-hidden">
          <img src="/images/turbo-hero.png" alt="Turbo" class="h-72 md:h-96 object-contain">
        </div>
      </div>
    </div>
  </section>

{{-- BEST SELLERS --}}
<section class="max-w-7xl mx-auto px-6 py-14">
  <h2 class="text-3xl font-extrabold text-red-400">Best Sellers</h2>

  <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach(($bestSellers ?? []) as $p)
      <a href="{{ route('products.show', $p['slug']) }}"
         class="group rounded-2xl overflow-hidden bg-white/5 border border-white/10 hover:border-white/20">
        <div class="aspect-[4/3] overflow-hidden">
          <img src="/images/{{ $p['image'] }}" alt="{{ $p['name'] }}"
               class="w-full h-full object-cover group-hover:scale-105 transition" />
        </div>
        <div class="p-4">
          <div class="font-semibold">{{ $p['name'] }}</div>
          <div class="text-sm text-gray-300 mt-1">Rs. {{ number_format($p['price'], 2) }}</div>
        </div>
      </a>
    @endforeach
  </div>
</section>


  {{-- CATEGORIES --}}
  <section class="max-w-7xl mx-auto px-6 pb-20">
    <h2 class="text-3xl font-extrabold">Shop by category</h2>
    <div class="mt-6 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach(($categories ?? [
          ['name'=>'Turbo Chargers','image'=>'cat-turbo.png'],
          ['name'=>'Wheels & Tires','image'=>'cat-wheels.png'],
          ['name'=>'Universal Parts','image'=>'cat-universal.png'],
          ['name'=>'Accessories','image'=>'cat-accessories.png'],
      ]) as $c)
        <div class="rounded-2xl bg-white/5 border border-white/10 overflow-hidden">
          <div class="aspect-video">
            <img src="/images/{{ is_array($c)?$c['image']:$c->image }}" class="w-full h-full object-cover" alt="">
          </div>
          <div class="p-4 font-medium">{{ is_array($c)?$c['name']:$c->name }}</div>
        </div>
      @endforeach
    </div>
  </section>
</x-app-layout>
