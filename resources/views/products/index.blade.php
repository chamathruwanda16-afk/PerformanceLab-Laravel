<x-app-layout>
  @php
    // Safe fallback if controller forgot to pass categories
    if (!isset($categories)) {
        try {
            $categories = \App\Models\Category::orderBy('name')->get(['id','name','slug']);
        } catch (\Throwable $e) {
            $categories = collect();
        }
    }
    $bySlug = $categories instanceof \Illuminate\Support\Collection
        ? $categories->keyBy('slug')
        : collect();

    // keep search value stable
    $q = $q ?? request('q');
  @endphp

  <div class="max-w-7xl mx-auto px-6 py-10">
    {{-- Header + search --}}
    <div class="flex items-end justify-between gap-4">
      <div>
        <h1 class="text-3xl font-extrabold">Products</h1>
        <p class="text-gray-300 mt-1">Browse our collection of performance parts.</p>
      </div>
      <form method="GET" class="w-full max-w-sm">
        {{-- Preserve category when searching --}}
        @if(request('category'))
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        <input
          name="q"
          value="{{ $q }}"
          placeholder="Search products…"
          class="w-full rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/30"
        />
      </form>
    </div>

    {{-- Layout: sidebar + grid --}}
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8">
      {{-- Sidebar --}}
      <aside class="lg:col-span-3">
        <div class="rounded-xl border border-white/10 bg-white/5 p-4">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Categories</h2>
            @if(request()->has('category') || request()->has('q'))
              <a href="{{ route('products.index') }}"
                 class="text-xs underline hover:no-underline">Clear</a>
            @endif
          </div>

          <ul class="mt-3 space-y-1">
            {{-- All --}}
            <li>
              <a href="{{ route('products.index', array_filter(['q' => request('q')])) }}"
                 class="block rounded-lg px-3 py-2 text-sm hover:bg-white/5 {{ request('category') ? '' : 'bg-white/10 font-semibold' }}">
                 All Products
              </a>
            </li>

            {{-- Pinned examples (optional) --}}
            <li>
              <a href="{{ route('products.index', array_filter(['category' => 'universal-parts', 'q' => request('q')])) }}"
                 class="block rounded-lg px-3 py-2 text-sm hover:bg-white/5 {{ request('category') === 'universal-parts' ? 'bg-white/10 font-semibold' : '' }}">
                 Universal Parts
                 @if($bySlug->has('universal-parts')) <span class="sr-only">(exists)</span> @endif
              </a>
            </li>
            <li>
              <a href="{{ route('products.index', array_filter(['category' => 'wheels', 'q' => request('q')])) }}"
                 class="block rounded-lg px-3 py-2 text-sm hover:bg-white/5 {{ request('category') === 'wheels' ? 'bg-white/10 font-semibold' : '' }}">
                 Wheels
                 @if($bySlug->has('wheels')) <span class="sr-only">(exists)</span> @endif
              </a>
            </li>

            {{-- All categories --}}
            <li class="mt-3 pt-3 border-t border-white/10 text-xs uppercase tracking-wide text-gray-400">All categories</li>
            @foreach($categories as $cat)
              <li>
                <a href="{{ route('products.index', array_filter(['category' => $cat->slug, 'q' => request('q')])) }}"
                   class="block rounded-lg px-3 py-2 text-sm hover:bg-white/5 {{ request('category') === $cat->slug ? 'bg-white/10 font-semibold' : '' }}">
                   {{ $cat->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </aside>

      {{-- Product grid --}}
      <section class="lg:col-span-9">
        @if(($products ?? collect())->count() === 0)
          <div class="rounded-xl border border-white/10 bg-white/5 p-8 text-center">
            <p class="text-gray-300">No products found.</p>
          </div>
        @else
          <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($products as $product)
              @php
                $raw = $product->image_path;
                $img = $raw
                    ? (\Illuminate\Support\Str::startsWith($raw, ['http://','https://']) ? $raw : asset(ltrim($raw, '/')))
                    : asset('images/placeholder.jpg'); // ensure this exists
              @endphp

              <a href="{{ route('products.show', $product->slug) }}"
                 class="group rounded-xl overflow-hidden bg-white/5 border border-white/10 hover:border-white/20">
                <div class="aspect-square overflow-hidden">
                  <img src="{{ $img }}"
                       alt="{{ $product->name }}"
                       class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                </div>
                <div class="p-4">
                  <div class="font-semibold">{{ $product->name }}</div>
                  <div class="text-sm text-gray-300 mt-1 line-clamp-2">
                    {{ $product->short_description ?? \Illuminate\Support\Str::limit($product->description, 80) }}
                  </div>
                  <div class="mt-2 font-semibold">Rs. {{ number_format($product->price, 2) }}</div>
                  @if($product->category)
                    <div class="mt-1 text-xs text-gray-400">Category: {{ $product->category->name }}</div>
                  @endif
                </div>
              </a>
            @endforeach
          </div>

          <div class="mt-8">
            {{ $products->withQueryString()->links() }}
          </div>
        @endif
      </section>
    </div>
  </div>
</x-app-layout>
