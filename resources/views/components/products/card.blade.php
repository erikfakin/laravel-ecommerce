<a href="{{ route('products.show', ['product' => $product->id]) }}" class="group relative block overflow-hidden">
    <img src="{{ asset('/storage/' . $product->image->src) }}" alt="{{ $product->image->alt }}"
        class="h-64 w-full object-contain transition duration-500 group-hover:scale-105 sm:h-72" />

    <div class="relative border border-gray-100 bg-white p-6">
        <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $product->name }}</h3>

        <p class="mt-1.5 text-sm text-gray-700">
            {{ number_format($product->price, 2, '.', '') }} €
        </p>

        <x-products.addToCart :productId="$product->id" />
    </div>
</a>
